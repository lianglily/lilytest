#!/bin/sh
Cur_Dir=$(cd `dirname $0`; pwd)
echo $Cur_Dir;
time1=$(date)
echo $time1;
echo "##############ALL BEGINING###############";
`./yii sap/sap/ftpuploadsap`

echo "##############ALL COMPLETE###############";