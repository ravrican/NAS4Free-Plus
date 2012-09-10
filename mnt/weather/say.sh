echo "In the city of Lida .." > /mnt/weather/pogoda.txt
curl -s "http://www.google.com/ig/api?weather=Hrodna" | sed 's|.*<temp_c data="\([^"]*\)"/>.*|\1|' >> /mnt/weather/pogoda.txt
echo ".. degrees" >> /mnt/weather/pogoda.txt
/usr/local/bin/festival --tts /mnt/weather/pogoda.txt
# rm /mnt/weather/pogoda.txt