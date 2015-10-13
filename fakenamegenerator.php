<?php

/**
 * @description A fake name generator that uses Turkish data as default, written in PHP.
 * @version 1.0
 * @author Samed Duzcay <samedduzcay@gmail.com>
 */

class fakeNameGenerator
{
    protected $apiKey = 'YOUR_API_KEY'; // Google API Key for geocoding, required for generating random address.
    public $latitude;
    public $longitude;

    // Default random area is generated for Istanbul, specifically an area within Europe region
    protected $startingLatitude = '410000000'; // Starting latitude for randomizing
    protected $endingLatitude = '410500000'; // Ending latitude for randomizing
    protected $startingLongitude = '288000000'; // Starting longitude for randomizing
    protected $endingLongitude = '289300000'; // Ending longitude for randomizing

    public $addressArray;
    public $names;
    public $surnames;
    public $phoneSuffixes;
    public $birthday;
    public $age;

    /**
     * Language settings
     * Default language is Turkish
     */
    const NAME_TEXT = 'Ad';
    const PHONE_TEXT = 'Telefon';
    const BIRTHDAY_TEXT = 'Doğum tarihi';
    const AGE_TEXT = 'Yaş';
    const ADDRESS_TEXT = 'Adres';


    /**
     * This is the place where almost every parameter is set before use
     */
    public function __construct()
    {

        // Set "names" haystack, default names are in Turkish
        $this->names = array('Abdulkadir', 'Abdullah', 'Abdurrahman', 'Ada', 'Adem', 'Adil', 'Ahmet', 'Ali', 'Ali Osman', 'Aliye', 'Alperen', 'Aras', 'Arda', 'Arif', 'Arife', 'Asiye', 'Aslı', 'Asmin', 'Asya', 'Ayaz', 'Aynur', 'Aysel', 'Aysima', 'Ayten', 'Ayşe', 'Ayşegül', 'Ayşenur', 'Aziz', 'Azra', 'Bahar', 'Baran', 'Barış', 'Batuhan', 'Bayram', 'Bedirhan', 'Bedriye', 'Bekir', 'Belinay', 'Berat', 'Beren', 'Berfin', 'Beril', 'Berkay', 'Berra', 'Betül', 'Beyza', 'Bilal', 'Burak', 'Buğlem', 'Bünyamin', 'Büşra', 'Cafer', 'Can', 'Celal', 'Cemal', 'Cemil', 'Cemile', 'Cemre', 'Cennet', 'Ceren', 'Ceylin', 'Cuma', 'Damla', 'Defne', 'Deniz', 'Derin', 'Devran', 'Doruk', 'Dudu', 'Duran', 'Durmuş', 'Dursun', 'Duru', 'Döndü', 'Döne', 'Ebrar', 'Ebubekir', 'Ece', 'Ecrin', 'Eda', 'Edanur', 'Efe', 'Ege', 'Egemen', 'Ekrem', 'Ela', 'Elanur', 'Elif', 'Elif Naz', 'Elif Nur', 'Elif Su', 'Elife', 'Elifnur', 'Elmas', 'Emin', 'Emine', 'Emir', 'Emirhan', 'Emre', 'Enes', 'Ensar', 'Enver', 'Erdem', 'Eren', 'Erol', 'Erva', 'Esila', 'Eslem', 'Esma', 'Esma Nur', 'Esmanur', 'Esra', 'Eylül', 'Eymen', 'Eyüp', 'Fadime', 'Fahrettin', 'Fahri', 'Fatih', 'Fatma', 'Fatma Nur', 'Fatma Zehra', 'Fatmanur', 'Feride', 'Fevzi', 'Feyza', 'Fikret', 'Fikriye', 'Furkan', 'Gönül', 'Güler', 'Güllü', 'Gülseren', 'Gülsüm', 'Gülten', 'Gülüzar', 'Gülşen', 'Habibe', 'Hacer', 'Hafize', 'Hakkı', 'Halil', 'Halil İbrahim', 'Halime', 'Halit', 'Hamdi', 'Hamide', 'Hamit', 'Hamza', 'Hanife', 'Hanım', 'Harun', 'Hasan', 'Hasan Hüseyin', 'Hatice', 'Hatice Kübra', 'Hatun', 'Hava', 'Havin', 'Havva', 'Haydar', 'Hayrettin', 'Hayriye', 'Hayrunnisa', 'Hazal', 'Hediye', 'Hikmet', 'Hilal', 'Hira', 'Hira Nur', 'Hiranur', 'Huriye', 'Hümeyra', 'Hüseyin', 'Irmak', 'Kaan', 'Kadir', 'Kadriye', 'Kamil', 'Kamile', 'Kazım', 'Kemal', 'Kerem', 'Kezban', 'Keziban', 'Kuzey', 'Kübra', 'Kıymet', 'Kız İsimleri', 'Leyla', 'Lütfiye', 'Mahir', 'Mahmut', 'Makbule', 'Medine', 'Mehmet', 'Mehmet Akif', 'Mehmet Ali', 'Mehmet Efe', 'Mehmet Emin', 'Melahat', 'Melek', 'Meliha', 'Melike', 'Melis', 'Melisa', 'Memet', 'Mert', 'Merve', 'Meryem', 'Mete', 'Metehan', 'Metin', 'Mevlüt', 'Mina', 'Mira', 'Miray', 'Miraç', 'Muammer', 'Muhammed', 'Muhammed Ali', 'Muhammed Emin', 'Muhammed Emir', 'Muhammed Enes', 'Muhammed Talha', 'Muhammed Yusuf', 'Muhammed mustafa', 'Muhammet', 'Muhammet Ali', 'Muharrem', 'Murat', 'Musa', 'Mustafa', 'Muzaffer', 'Münevver', 'Müzeyyen', 'Naciye', 'Naime', 'Nazife', 'Nazlı', 'Nazmiye', 'Nebahat', 'Necati', 'Necla', 'Nehir', 'Neriman', 'Nermin', 'Nevzat', 'Nihat', 'Nimet', 'Nisa', 'Nisa Nur', 'Nisanur', 'Niyazi', 'Nurettin', 'Nuri', 'Nuriye', 'Nurten', 'Onur', 'Orhan', 'Osman', 'Pakize', 'Perihan', 'Poyraz', 'Rabia', 'Rahime', 'Ramazan', 'Ravza', 'Raziye', 'Recep', 'Remzi', 'Remziye', 'Rukiye', 'Rümeysa', 'Rüzgar', 'Rıza', 'Saadet', 'Sabri', 'Sabriye', 'Sadık', 'Safiye', 'Salih', 'Saliha', 'Salim', 'Samet', 'Sami', 'Saniye', 'Satı', 'Sebahat', 'Seher', 'Selahattin', 'Selim', 'Semanur', 'Semiha', 'Serhat', 'Sevim', 'Sudenaz', 'Sultan', 'Süleyman', 'Sümeyye', 'Taha', 'Tahir', 'Tahsin', 'Talha', 'Tuana', 'Tuğba', 'Türkan', 'Umut', 'Veli', 'Yakup', 'Yaren', 'Yasin', 'Yavuz Selim', 'Yağmur', 'Yağız', 'Yaşar', 'Yeter', 'Yiğit', 'Yunus', 'Yunus Emre', 'Yusuf', 'Yusuf Eymen', 'Yüks', 'Yılmaz', 'Zahide', 'Zehra', 'Zeki', 'Zekiye', 'Zeliha', 'Zeynep', 'Ziya', 'Zümra', 'Ömer', 'Ömer Asaf', 'Ömer Faruk', 'Öykü', 'Çınar', 'İbrahim', 'İbrahim Halil', 'İhsan', 'İkra', 'İlayda', 'İlyas', 'İpek', 'İrem', 'İrfan', 'İsa', 'İsmail', 'İsmet', 'İzzet', 'Şaban', 'Şaziye', 'Şerafettin', 'Şerife', 'Şevket', 'Şevval', 'Şeyma', 'Şükran', 'Şükriye', 'Şükrü');

        // Set "surnames" haystack, default surnames are in Turkish
        $this->surnames = array('Abacı', 'Abadan', 'Aclan', 'Adal', 'Adan', 'Adıvar', 'Akal', 'Akan', 'Akar', 'Akay', 'Akaydın', 'Akbulut', 'Akgül', 'Akışık', 'Akman', 'Akyürek', 'Akyüz', 'Akşit', 'Alnıaçık', 'Alpuğan', 'Alyanak', 'Arıcan', 'Arslanoğlu', 'Atakol', 'Atan', 'Avan', 'Ayaydın', 'Aybar', 'Aydan', 'Aykaç', 'Ayverdi', 'Ağaoğlu', 'Aşıkoğlu', 'Babacan', 'Babaoğlu', 'Bademci', 'Bakırcıoğlu', 'Balaban', 'Balcı', 'Barbarosoğlu', 'Baturalp', 'Baykam', 'Başoğlu', 'Berberoğlu', 'Beşerler', 'Beşok', 'Biçer', 'Bolatlı', 'Dalkıran', 'Dağdaş', 'Dağlaroğlu', 'Demirbaş', 'Demirel', 'Denkel', 'Dizdar', 'Doğan', 'Durak', 'Durmaz', 'Duygulu', 'Düşenkalkar', 'Egeli', 'Ekici', 'Ekşioğlu', 'Eliçin', 'Elmastaşoğlu', 'Elçiboğa', 'Erbay', 'Erberk', 'Erbulak', 'Erdoğan', 'Erez', 'Erginsoy', 'Erkekli', 'Eronat', 'Ertepınar', 'Ertürk', 'Erçetin', 'Evliyaoğlu', 'Fahri', 'Gönültaş', 'Gümüşpala', 'Günday', 'Gürmen', 'Hakyemez', 'Hamzaoğlu', 'Ilıcalı', 'Kahveci', 'Kaplangı', 'Karabulut', 'Karaböcek', 'Karadaş', 'Karaduman', 'Karaer', 'Kasapoğlu', 'Kavaklıoğlu', 'Kaya', 'Keseroğlu', 'Keçeci', 'Kılıççı', 'Kıraç', 'Kocabıyık', 'Korol', 'Koyuncu', 'Koç', 'Koçoğlu', 'Koçyiğit', 'Kuday', 'Kulaksızoğlu', 'Kumcuoğlu', 'Kunt', 'Kunter', 'Kurutluoğlu', 'Kutlay', 'Kuzucu', 'Körmükçü', 'Köybaşı', 'Köylüoğlu', 'Küçükler', 'Limoncuoğlu', 'Mayhoş', 'Menemencioğlu', 'Mertoğlu', 'Nalbantoğlu', 'Nebioğlu', 'Numanoğlu', 'Okumuş', 'Okur', 'Oraloğlu', 'Orbay', 'Ozansoy', 'Paksüt', 'Pekkan', 'Pektemek', 'Polat', 'Poyrazoğlu', 'Poçan', 'Sadıklar', 'Samancı', 'Sandalcı', 'Sarıoğlu', 'Saygıner', 'Sepetçi', 'Sezek', 'Sinanoğlu', 'Solmaz', 'Sözeri', 'Süleymanoğlu', 'Tahincioğlu', 'Tanrıkulu', 'Tazegül', 'Taşlı', 'Taşçı', 'Tekand', 'Tekelioğlu', 'Tokatlıoğlu', 'Tokgöz', 'Topaloğlu', 'Topçuoğlu', 'Toraman', 'Tunaboylu', 'Tunçeri', 'Tuğlu', 'Tuğluk', 'Türkdoğan', 'Türkyılmaz', 'Tütüncü', 'Tüzün', 'Uca', 'Uluhan', 'Velioğlu', 'Yalçın', 'Yazıcı', 'Yetkiner', 'Yeşilkaya', 'Yıldırım', 'Yıldızoğlu', 'Yılmazer', 'Yorulmaz', 'Çamdalı', 'Çapanoğlu', 'Çatalbaş', 'Çağıran', 'Çetin', 'Çetiner', 'Çevik', 'Çörekçi', 'Önür', 'Örge', 'Öymen', 'Özberk', 'Özbey', 'Özbir', 'Özdenak', 'Özdoğan', 'Özgörkey', 'Özkara', 'Özkök', 'Öztonga', 'Öztuna');

        // Set "phonesuffixes" haystack, default phonesuffixes are for Avea-Turkcell-Vodafone, which are Turkish mobile carriers
        $this->phoneSuffixes = array('530', '531', '532', '533', '534', '535', '536', '537', '538', '539', '540', '541', '542', '543', '544', '545', '546', '547', '548', '549', '552', '553', '554', '555', '559', '505', '506', '507');
    }

    /**
     * @param string $url cURL connection will be established to this URL
     * @return string HTML output
     */
    public function connect($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param int $start Starting coordinate
     * @param int $end Ending coordinate
     * @return string mixed Returns google-friendly random coordinate between start and end
     */
    public function getRandCoordinate($start, $end)
    {
        return substr_replace(mt_rand((int)$start, (int)$end), '.', 2, 0);
    }

    /**
     * @return string Full address which is formatted automatically by Google
     */
    public function getAddress()
    {
        /**
         * Some useful data in $address array
         *
         *  [results]
         *      [0]
         *          [address_components]
         *              [0] -> Some data (street number etc.)
         *              [1] -> Some data (route etc.)
         *              ...
         *          [formatted_address]
         *          [geometry]
         *              [location]
         *                  [lat] -> Latitude
         *                  [lng] -> Longitude
         *
         */
        $this->addressArray = json_decode($this->connect("https://maps.googleapis.com/maps/api/geocode/json?latlng={$this->latitude},{$this->longitude}&key={$this->apiKey}"), true);

        return $this->addressArray['results'][0]['formatted_address'];
    }

    /**
     * @return string Random name-surname
     */
    public function getName()
    {
        return $this->names[mt_rand(0, count($this->names) - 1)] . " " . $this->surnames[mt_rand(0, count($this->surnames) - 1)];
    }

    /**
     * @return string Random phone number
     */
    public function getPhone()
    {
		// return $this->phoneSuffixes[mt_rand(0, count($this->phoneSuffixes) - 1)] . " - " . mt_rand(100, 999) . mt_rand(1000, 9999);
        return $this->phoneSuffixes[mt_rand(0, count($this->phoneSuffixes) - 1)] . mt_rand(100, 999) . mt_rand(1000, 9999);
    }

    /**
     * @param int $minYear Minimum birthday year
     * @param int $maxYear Maximum birthday year
     * @return string Random birthday
     */
    public function getBirthday($minYear, $maxYear)
    {
        $this->birthday = date('d-m-Y', mt_rand(strtotime((int)$minYear), strtotime((int)$maxYear)));
        $this->age = date("Y") - substr($this->birthday, -4);
        return $this->birthday;
    }

    /**
     * This function sets random coordinates
     */
    public function setCoordinate()
    {
        $this->latitude = $this->getRandCoordinate($this->startingLatitude, $this->endingLatitude);
        $this->longitude = $this->getRandCoordinate($this->startingLongitude, $this->endingLongitude);
    }

    /**
     * @return string This function creates random name with random address everytime you call
     */
    public function create()
    {
        $this->setCoordinate();
        $data = "";
        $tryCount = 0;
        while ($tryCount < 5 && $this->addressArray['results'][0]['address_components'][0]['types']['0'] != 'street_number') { // Try coordinates until it's a home address, but not more than 5 times
            $data = self::NAME_TEXT . ": " . $this->getName() . "<br/>" . self::PHONE_TEXT . ": " . $this->getPhone() . "<br/>" . self::BIRTHDAY_TEXT . ": " . $this->getBirthday('1960', '1990') . "<br/>" . self::AGE_TEXT . ": " . $this->age . "<br/>" . self::ADDRESS_TEXT . ": " . $this->getAddress() . "<br/>";
            $tryCount++;
        }
        return $data;
    }

}

?>
<!--
@description Fake name generator in Turkish
@author Samed Duzcay <samedduzcay(at)gmail(dot)com>
-->
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fake Name Generator</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!--
    Not necessary for now.
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    -->
</head>
<body>
<div class="container">
    <div class="page-header" style="margin-top:10%;">
        <h1>Fake Name Generator</h1>
    </div>
    <div class="jumbotron" style="font-size:24px;">
        <?php
        $fakeName = new fakeNameGenerator;
        echo $fakeName->create(); // Print the data
        PHP_EOL;
        ?>
    </div>
    <p class="text-muted">Nefasetle efenim.</p>
</div>
</body>
</html>