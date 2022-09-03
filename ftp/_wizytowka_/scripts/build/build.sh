#!/bin/bash

rootAppDir=$( dirname $( dirname $( dirname ${BASH_SOURCE[0]} ) ) )

if [ $# -lt 2 ]
then
    echo "No require parameters !!!"
    echo "Try like this: $rootAppDir [login] [pass]"
    exit 1
fi

#credentials file exist
if [ -f "$rootAppDir/application/configs/basicPasswd.txt" ]; then
    echo "file : $rootAppDir/application/configs/basicPasswd.txt already exist"
    exit 1
fi

#credentials *-dist file exist
if [ !  -f "$rootAppDir/application/configs/basicPasswd.txt-dist" ]; then
    echo "file : $rootAppDir/application/configs/basicPasswd.txt-dist do not exists"
    exit 1
fi

#create credentials file
cat $rootAppDir/application/configs/basicPasswd.txt-dist | sed s/%s/$1/ | sed s/%s/$2/ > $rootAppDir/application/configs/basicPasswd.txt
if [ $? -ne 0 ]; then
	echo "[error][created file] $rootAppDir/application/configs/basicPasswd.txt"
	exit 1;
fi
echo "[created file] $rootAppDir/application/configs/basicPasswd.txt"

# chmod 444 basicPasswd.txt
chmod 444 "$rootAppDir/application/configs/basicPasswd.txt"
if [ $? -ne 0 ]; then
	echo "[error][chmod] 444 $rootAppDir/application/configs/basicPasswd.txt"
	exit 1;
fi
echo "[chmod] 444 $rootAppDir/application/configs/basicPasswd.txt"


#create dirs and add privileges
#logs dir
if [  ! -d "$rootAppDir/data/logs" ]; then
    mkdir "$rootAppDir/data/logs"
    if [ $? -ne 0 ]; then
    	echo "[error][mkdir] $rootAppDir/data/logs"
    	exit 1;
    fi
    echo "[mkdir] $rootAppDir/data/logs"

    if [ $? -ne 0 ]; then
        echo "[error] [chmod] 777 -R $rootAppDir/data/logs"
        exit 1;
    fi
    chmod 777 -R "$rootAppDir/data/logs"
    echo "[chmod] 777 -R $rootAppDir/data/logs"
fi

# businesscard data.json
# test data.json
if [ !  -f "$rootAppDir/data/storages/data.json" ]; then
    echo "file : $rootAppDir/data/storages/data.json do not exists"
    exit 1
fi

chmod 666 "$rootAppDir/data/storages/data.json"

if [ $? -ne 0 ]; then
	echo "[error][chmod] 666 $rootAppDir/data/storages/data.json"
	exit 1;
fi
echo "[chmod] 666 $rootAppDir/data/storages/data.json"

#test default/data.json
if [ !  -f "$rootAppDir/data/storages/default/data.json" ]; then
    echo "file : $rootAppDir/data/storages/default/data.json do not exists"
    exit 1
fi

chmod 666 "$rootAppDir/data/storages/default/data.json"

if [ $? -ne 0 ]; then
	echo "[error][chmod] 666 $rootAppDir/data/storages/default/data.json"
	exit 1;
fi
echo "[chmod] 666 $rootAppDir/data/storages/default/data.json"

exit 0


