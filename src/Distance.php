<?php

namespace Distance;

/**
 * Distance
 */
class Distance
{
    /**
     * ２地点間の距離(m)を求める
     * ヒュベニの公式から求めるバージョン
     * Hybeny Distance Formula
     *
     * @param Coordinate $coordinate1 始点座標
     * @param Coordinate $coordinate2 終点座標
     * @param boolean $mode 測地系 true:世界(default) false:日本
     * @return float 距離(m)
     */
    public static function hybeny(Coordinate $coordinate1, Coordinate $coordinate2, $mode = true)
    {
        $lat1 = $coordinate1->lat();
        $lon1 = $coordinate1->lon();
        $lat2 = $coordinate2->lat();
        $lon2 = $coordinate2->lon();

        // 緯度経度をラジアンに変換
        $radLat1 = deg2rad($lat1); // 緯度（始点）
        $radLon1 = deg2rad($lon1); // 経度（始点）
        $radLat2 = deg2rad($lat2); // 緯度(終点)
        $radLon2 = deg2rad($lon2); // 経度(終点)

        // 緯度差
        $radLatDiff = abs($radLat1 - $radLat2);

        // 経度差算(距離の短い方を採用する)
        $radLonDiff = abs($radLon1 - $radLon2);
        $radLonDiff = min($radLonDiff, 2 * pi() - $radLonDiff);

        // 平均緯度
        $radLatAve = ($radLat1 + $radLat2) / 2.0;

        // 測地系による値の違い
        $a = $mode ? 6378137.0 : 6377397.155; // 赤道半径

        // $b = $mode ? 6356752.314140356 : 6356078.963; // 極半径
        //$e2 = ($a * $a - $b * $b) / ($a * $a);
        $e2 = $mode ? 0.00669438002301188 : 0.00667436061028297; // 第一離心率^2

        //$a1e2 = $a * (1 - $e2);
        $a1e2 = $mode ? 6335439.32708317 : 6334832.10663254; // 赤道上の子午線曲率半径

        $sinLat = sin($radLatAve);
        $w2 = 1.0 - $e2 * ($sinLat * $sinLat);
        $m = $a1e2 / (sqrt($w2) * $w2); // 子午線曲率半径M
        $n = $a / sqrt($w2); // 卯酉線曲率半径

        $t1 = $m * $radLatDiff;
        $t2 = $n * cos($radLatAve) * $radLonDiff;
        $dist = sqrt(($t1 * $t1) + ($t2 * $t2));

        return $dist;
    }

    /**
     * ２地点間の距離(m)を求める
     * 球面三角法
     *   GoogleMapAPIのgeometory.computeDistanceBetweenのロジック
     *   浮動小数点の精度が足りないためGoogleより桁数が少ないかもしれません
     *
     * @param Coordinate $coordinate1 始点座標
     * @param Coordinate $coordinate2 終点座標
     * @return float 距離(m)
     */
    public static function sphericalTrigonometry(Coordinate $coordinate1, Coordinate $coordinate2)
    {
        $lat1 = $coordinate1->lat();
        $lon1 = $coordinate1->lon();
        $lat2 = $coordinate2->lat();
        $lon2 = $coordinate2->lon();

        // 緯度経度をラジアンに変換
        $radLat1 = deg2rad($lat1); // 緯度(始点)
        $radLon1 = deg2rad($lon1); // 経度(始点)
        $radLat2 = deg2rad($lat2); // 緯度(終点)
        $radLon2 = deg2rad($lon2); // 経度(終点)

        $r = 6378137.0; // 赤道半径

        $averageLat = ($radLat1 - $radLat2) / 2;
        $averageLon = ($radLon1 - $radLon2) / 2;
        return $r * 2 * asin(sqrt(pow(sin($averageLat), 2) + cos($radLat1) * cos($radLat2) * pow(sin($averageLon), 2)));
    }

    /**
     * ２地点間の距離(m)を求める
     * 測地線航海算法バージョン
     *
     * @param Coordinate $coordinate1 始点座標
     * @param Coordinate $coordinate2 終点座標
     * @return float 距離(m)
     */
    public static function geodesicSailing(Coordinate $coordinate1, Coordinate $coordinate2)
    {
        $lat1 = $coordinate1->lat();
        $lon1 = $coordinate1->lon();
        $lat2 = $coordinate2->lat();
        $lon2 = $coordinate2->lon();

        // 緯度経度をラジアンに変換
        $radLat1 = deg2rad($lat1); // 緯度（始点）
        $radLon1 = deg2rad($lon1); // 経度（始点）
        $radLat2 = deg2rad($lat2); // 緯度(終点)
        $radLon2 = deg2rad($lon2); // 経度(終点)

        $equatorialRadius = 6378137.0; // 赤道半径
        // $B = 6356752.314140356; // 極半径
        // $F = ($equatorialRadius - $B) / $equatorialRadius;
        $oblateness = 0.003352858356825; // 扁平率

        $bDivEquatorialRadius = 0.99664714164317; // $B/$A
        $p1 = atan($bDivEquatorialRadius * tan($radLat1));
        $p2 = atan($bDivEquatorialRadius * tan($radLat2));

        $sd = acos(sin($p1) * sin($p2) + cos($p1) * cos($p2) * cos($radLon1 - $radLon2));

        $cosSd = cos($sd / 2);
        $sinSd = sin($sd / 2);
        $c = (sin($sd) - $sd) * pow(sin($p1) + sin($p2), 2) / $cosSd / $cosSd;
        $s = (sin($sd) + $sd) * pow(sin($p1) - sin($p2), 2) / $sinSd / $sinSd;
        $delta = $oblateness / 8.0 * ($c - $s);

        return $equatorialRadius * ($sd + $delta);
    }
}
