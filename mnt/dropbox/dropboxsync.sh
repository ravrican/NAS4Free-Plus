########################################################################
# Syncing script     dropboxsync.sh
# Goal            Dropbox<-->Transmission
# Use             https://github.com/s-aska/dropbox-api-command
# By             rvm.my.home.s@gmail.com
# URL            http://mytoiletserver.blogspot.com/

### SYNC_OPTIONS:
# -v -- Verbose
# -d -- Delete

API_BIN="/usr/local/bin/dropbox-api"
SYNC_OPTIONS="-d"
DROPBOX_REMOTE_FOLDER="dropbox:/_torrent_/_new_/"
LOCAL_SYNC_FOLDER="/mnt/1TB/_torrent_/_new_/"
LOG_FILE="dropboxsync.log"
LOG_FILEPATH="/mnt/dropbox/$LOG_FILE"
SYNC_PAUSE_SECONDS=30
START_MESSAGE=">>>>>>>>>> Now syncing '`hostname`' with Dropbox [UID=`dropbox-api uid`]"
END_MESSAGE="<<<<<<<<<< Syncing complete!"
PAUSE_MESSAGE="========== Syncing now sleeping $SYNC_PAUSE_SECONDS seconds for Transmission work..."
DATE_FORMAT="date +%t%d.%m.%Y%t%k:%M:%S%t"

echo "*****************************************" >> ${LOG_FILEPATH}
MESSAGE="echo Current dir:  `pwd`"
$MESSAGE >> ${LOG_FILEPATH}
MESSAGE="echo Current user: `id`"
$MESSAGE >> ${LOG_FILEPATH}
MESSAGE="echo `$DATE_FORMAT` $START_MESSAGE"
$MESSAGE >> ${LOG_FILEPATH}

### Command: Sync to Me
$API_BIN sync ${DROPBOX_REMOTE_FOLDER} ${LOCAL_SYNC_FOLDER} ${SYNC_OPTIONS} >> ${LOG_FILEPATH}

MESSAGE="echo `$DATE_FORMAT` $PAUSE_MESSAGE"
$MESSAGE >> ${LOG_FILEPATH}
sleep $SYNC_PAUSE_SECONDS

### Command: Sync to Dropbox
$API_BIN sync ${LOCAL_SYNC_FOLDER} ${DROPBOX_REMOTE_FOLDER} ${SYNC_OPTIONS} >> ${LOG_FILEPATH}

MESSAGE="echo `$DATE_FORMAT` $END_MESSAGE"
$MESSAGE >> ${LOG_FILEPATH}

### Command: Copy Log-File to Dropbox
#cp ${LOG_FILEPATH} ${LOCAL_SYNC_FOLDER}${LOG_FILE}
#$API_BIN put ${LOCAL_SYNC_FOLDER}${LOG_FILE} ${DROPBOX_REMOTE_FOLDER} 