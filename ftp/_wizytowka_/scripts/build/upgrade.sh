#!/bin/bash

rootAppDir=$( dirname $( dirname $( dirname ${BASH_SOURCE[0]} ) ) )

if [ $# -lt 2 ]
then
    echo "No require parameters !!!"
    echo "Try like this: $rootAppDir [current_dir] [source_dir]"
    exit 1
fi

#source dir
if [ ! -d "$2" ]; then
    echo "source directory : $2 do not exists"
    exit 1
fi
echo "[source dir] $2"

#current app dir
if [ ! -d "$1" ]; then
    echo "current app directory : $1 do not exists"
    exit 1
fi
echo "[current appdir] $1"

RSYNC="rsync -rlvz --delete-after --checksum  $2 $1 --exclude /application/configs/basicPasswd.txt --exclude /application/configs/basicPasswd.txt-dist --exclude /data/storages/data.json --exclude /data/logs"
$RSYNC;
if [ $? -ne 0 ]; then
	echo "[error] $RSYNC";
    exit 1
fi
echo "[success] $RSYNC";

# add privileges to businesscard files
# basicPasswd
chmod 444 "$1application/configs/basicPasswd.txt"
if [ $? -ne 0 ]; then
	echo "[error][chmod] 444 $1application/configs/basicPasswd.txt"
	exit 1
fi
echo "[chmod] 444 $1application/configs/basicPasswd.txt"

# test businesscard data.json
if [ !  -f "$1data/storages/data.json" ]; then
    echo "file : $1data/storages/data.json do not exists"
    exit 1
fi

#data.json
chmod 666 "$1data/storages/data.json"
if [ $? -ne 0 ]; then
	echo "[error][chmod] 666 $1data/storages/data.json"
	exit 1
fi
echo "[chmod] 666 $1data/storages/data.json"


#test default/data.json
if [ !  -f "$1data/storages/default/data.json" ]; then
    echo "file : $1data/storages/default/data.json do not exists"
    exit 1
fi

#default/data.json
chmod 666 "$1data/storages/default/data.json"
if [ $? -ne 0 ]; then
	echo "[error][chmod] 666 $1data/storages/default/data.json"
	exit 1
fi
echo "[chmod] 666 $1data/storages/default/data.json"

exit 0
