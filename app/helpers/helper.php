<?php

use App\Controller\Controller;
use App\helpers\Database as DB;

if(strpos($_SERVER['REQUEST_URI'], "/api") === false){
    if(in_array("pdo_sqlite", get_loaded_extensions()) && in_array("sqlite3", get_loaded_extensions())){
        new \App\helpers\Database();
        if(!\App\Controller\UserController::user()){
            if(strpos($_SERVER['REQUEST_URI'], "/login") !== false){
                $user = new \App\Controller\UserController();
                $user->login();
            } else {
                Controller::redirect("/login");
            }
        }
    } else {
        unset($_SESSION['auth']);
        unset($_SESSION['hasDatabase']);
    }
}

function defaultLanguageTranslate($forceGetDefault = false){
    $langFile = $forceGetDefault ? $forceGetDefault.".json" : strtolower("default.json");
    return json_decode(file_get_contents(__DIR__."/../languages/".$langFile));
}

function getSystemIcon(){
    if(!isset($_SESSION['SYS_ICON'])){
        $_SESSION['SYS_ICON'] = "fiv-sqo";
    }

    return $_SESSION['SYS_ICON'];
}

function translate($language_key = false){
    if($language_key){
        if(isset($_SESSION['SYS_LANG']->$language_key)){
            return $_SESSION['SYS_LANG']->$language_key;
        } else {
            return defaultLanguageTranslate()->$language_key ?? null;
        }
    } else {
        return $_SESSION['SYS_LANG'];
    }
}

function import($view, $viewData = []){
    return \App\Controller\Controller::render($view, $viewData);
}

function enableFeature($disableControl = false, $forceHidden = false){
    $features = [
        "/user",
        "/login",
        "/logout",
        "/iconChanger",
    ];

    $linkUrl = $disableControl ? $disableControl : $_SERVER['REQUEST_URI'];
    $linkUrl = strpos($linkUrl, "?") !== false ? explode("?", $linkUrl)[0] : $linkUrl;

    if(in_array($linkUrl, $features)){
        if($disableControl){
            $elementReturn = $forceHidden ? "hidden" : "disabled";
            return DB::isEnabled() ? "" : $elementReturn;
        } else {
            return DB::isEnabled();
        }
    }

    return true;
}

function sizer($n, $raw = false){
    return \AmplieSolucoes\EzFile\EzFile::sizeUnitFormatter($n, \AmplieSolucoes\EzFile\EzFile::UNIT_GIGABYTES);
}

function getAvatar($getById = false){
    $default = 'assets/images/user.png';
    if(DB::isEnabled()){
        $user = "assets/images/avatar/".($getById ? $getById : \App\Controller\UserController::user()['id']);
        return \AmplieSolucoes\EzFile\EzFile::exists($user) ? \AmplieSolucoes\EzFile\EzFile::list($user)[0] : $default;
    } else {
        return $default;
    }
}

function getStorageUsage($userId){
    $usage = ["percent" => "0", "usage" => "0 GB", "storage" => "Unlimited", "detail" => "Unlimited", "class" => ""];
    $user = DB::query("SELECT * FROM settings WHERE user_id = '".$userId."'")->first();

    if(!DB::isEnabled() || !$user || $user['storage_limit'] == "Unlimited"){
        return $usage;
    }

    $explodedType = explode(" ", $user['storage_limit']);
    $unitType = $explodedType[1];
    $totalSpace = $explodedType[0];
    $limit = (int)explode(" ", \AmplieSolucoes\EzFile\EzFile::sizeUnitFormatter($totalSpace, $unitType, true))[0];

    $explodedType = explode(" ", $user['storage_usage']);
    $usage = (int)explode(" ", \AmplieSolucoes\EzFile\EzFile::sizeUnitFormatter($explodedType[0], $explodedType[1], true))[0];

    $porcentageUsage = ceil((float)number_format(($usage / $limit) * 100, 2));
    $totalInGb = $user['storage_usage'];
    $usage = [
        "percent" => (string)$porcentageUsage,
        "usage" => $totalInGb,
        "storage" => $user['storage_limit'],
        "detail" => "$totalInGb / ".$user['storage_limit'],
        "class" => $porcentageUsage >= 90 ? "bg-danger" : ""
    ];

    return $usage;
}

function getAllCountries(){
    return [
        ['file' => 'afghanistan', 'description' => 'Afghanistan'],
        ['file' => 'albania', 'description' => 'Shqipëria'],
        ['file' => 'algeria', 'description' => 'الجزائر'],
        ['file' => 'andorra', 'description' => 'Andorra'],
        ['file' => 'angola', 'description' => 'Angola'],
        ['file' => 'antigua_and_barbuda', 'description' => 'Antigua and Barbuda'],
        ['file' => 'argentina', 'description' => 'Argentina'],
        ['file' => 'armenia', 'description' => 'Հայաստան'],
        ['file' => 'australia', 'description' => 'Australia'],
        ['file' => 'austria', 'description' => 'Österreich'],
        ['file' => 'azerbaijan', 'description' => 'Azərbaycan'],
        ['file' => 'bahamas', 'description' => 'Bahamas'],
        ['file' => 'bahrain', 'description' => '‏البحرين'],
        ['file' => 'bangladesh', 'description' => 'বাংলাদেশ'],
        ['file' => 'barbados', 'description' => 'Barbados'],
        ['file' => 'belarus', 'description' => 'Беларусь'],
        ['file' => 'belgium', 'description' => 'België'],
        ['file' => 'belize', 'description' => 'Belize'],
        ['file' => 'benin', 'description' => 'Bénin'],
        ['file' => 'bhutan', 'description' => 'འབྲུག་ཡུལ'],
        ['file' => 'bolivia', 'description' => 'Bolivia'],
        ['file' => 'bosnia_and_herzegovina', 'description' => 'Bosna i Hercegovina'],
        ['file' => 'botswana', 'description' => 'Botswana'],
        ['file' => 'brazil', 'description' => 'Brasil'],
        ['file' => 'brunei', 'description' => 'Brunei'],
        ['file' => 'bulgaria', 'description' => 'България'],
        ['file' => 'burkina_faso', 'description' => 'Burkina Faso'],
        ['file' => 'burundi', 'description' => 'Burundi'],
        ['file' => 'cabo_verde', 'description' => 'Cabo Verde'],
        ['file' => 'cambodia', 'description' => 'កម្ពុជា'],
        ['file' => 'cameroon', 'description' => 'Cameroon'],
        ['file' => 'canada', 'description' => 'Canada'],
        ['file' => 'central_african_republic', 'description' => 'République centrafricaine'],
        ['file' => 'chad', 'description' => 'Tchad'],
        ['file' => 'chile', 'description' => 'Chile'],
        ['file' => 'china', 'description' => '中国'],
        ['file' => 'colombia', 'description' => 'Colombia'],
        ['file' => 'comoros', 'description' => 'جزر القمر'],
        ['file' => 'congo_brazzaville', 'description' => 'Congo-Brazzaville'],
        ['file' => 'congo_kinshasa', 'description' => 'Congo-Kinshasa'],
        ['file' => 'costa_rica', 'description' => 'Costa Rica'],
        ['file' => 'croatia', 'description' => 'Hrvatska'],
        ['file' => 'cuba', 'description' => 'Cuba'],
        ['file' => 'cyprus', 'description' => 'Κύπρος'],
        ['file' => 'czech_republic', 'description' => 'Česká republika'],
        ['file' => 'denmark', 'description' => 'Danmark'],
        ['file' => 'djibouti', 'description' => 'Djibouti'],
        ['file' => 'dominica', 'description' => 'Dominica'],
        ['file' => 'dominican_republic', 'description' => 'República Dominicana'],
        ['file' => 'east_timor', 'description' => 'Timor-Leste'],
        ['file' => 'ecuador', 'description' => 'Ecuador'],
        ['file' => 'egypt', 'description' => 'مصر'],
        ['file' => 'el_salvador', 'description' => 'El Salvador'],
        ['file' => 'equatorial_guinea', 'description' => 'Guinea Ecuatorial'],
        ['file' => 'eritrea', 'description' => 'ኤርትራ'],
        ['file' => 'estonia', 'description' => 'Eesti'],
        ['file' => 'ethiopia', 'description' => 'ኢትዮጵያ'],
        ['file' => 'fiji', 'description' => 'Fiji'],
        ['file' => 'finland', 'description' => 'Suomi'],
        ['file' => 'france', 'description' => 'France'],
        ['file' => 'gabon', 'description' => 'Gabon'],
        ['file' => 'gambia', 'description' => 'Gambia'],
        ['file' => 'georgia', 'description' => 'საქართველო'],
        ['file' => 'germany', 'description' => 'Deutschland'],
        ['file' => 'ghana', 'description' => 'Ghana'],
        ['file' => 'greece', 'description' => 'Ελλάδα'],
        ['file' => 'grenada', 'description' => 'Grenada'],
        ['file' => 'guatemala', 'description' => 'Guatemala'],
        ['file' => 'guinea', 'description' => 'Guinée'],
        ['file' => 'guinea_bissau', 'description' => 'Guiné Bissau'],
        ['file' => 'guyana', 'description' => 'Guyana'],
        ['file' => 'haiti', 'description' => 'Haïti'],
        ['file' => 'honduras', 'description' => 'Honduras'],
        ['file' => 'hungary', 'description' => 'Magyarország'],
        ['file' => 'iceland', 'description' => 'Ísland'],
        ['file' => 'india', 'description' => 'भारत'],
        ['file' => 'indonesia', 'description' => 'Indonesia'],
        ['file' => 'iran', 'description' => 'ایران'],
        ['file' => 'iraq', 'description' => 'العراق'],
        ['file' => 'ireland', 'description' => 'Ireland'],
        ['file' => 'israel', 'description' => 'ישראל'],
        ['file' => 'italy', 'description' => 'Italia'],
        ['file' => 'ivory_coast', 'description' => "Côte d'Ivoire"],
        ['file' => 'jamaica', 'description' => 'Jamaica'],
        ['file' => 'japan', 'description' => '日本'],
        ['file' => 'jordan', 'description' => 'الأردن'],
        ['file' => 'kazakhstan', 'description' => 'Қазақстан'],
        ['file' => 'kenya', 'description' => 'Kenya'],
        ['file' => 'kiribati', 'description' => 'Kiribati'],
        ['file' => 'korea_north', 'description' => '북한'],
        ['file' => 'korea_south', 'description' => '대한민국'],
        ['file' => 'kosovo', 'description' => 'Kosova'],
        ['file' => 'kuwait', 'description' => 'الكويت'],
        ['file' => 'kyrgyzstan', 'description' => 'Кыргызстан'],
        ['file' => 'laos', 'description' => 'ລາວ'],
        ['file' => 'latvia', 'description' => 'Latvija'],
        ['file' => 'lebanon', 'description' => 'لبنان'],
        ['file' => 'lesotho', 'description' => 'Lesotho'],
        ['file' => 'liberia', 'description' => 'Liberia'],
        ['file' => 'libya', 'description' => 'ليبيا'],
        ['file' => 'liechtenstein', 'description' => 'Liechtenstein'],
        ['file' => 'lithuania', 'description' => 'Lietuva'],
        ['file' => 'luxembourg', 'description' => 'Luxembourg'],
        ['file' => 'macedonia', 'description' => 'Македонија'],
        ['file' => 'madagascar', 'description' => 'Madagascar'],
        ['file' => 'malawi', 'description' => 'Malawi'],
        ['file' => 'malaysia', 'description' => 'Malaysia'],
        ['file' => 'maldives', 'description' => 'Maldives'],
        ['file' => 'mali', 'description' => 'Mali'],
        ['file' => 'malta', 'description' => 'Malta'],
        ['file' => 'marshall_islands', 'description' => 'Marshall Islands'],
        ['file' => 'mauritania', 'description' => 'Mauritanie'],
        ['file' => 'mauritius', 'description' => 'Mauritius'],
        ['file' => 'mexico', 'description' => 'México'],
        ['file' => 'micronesia', 'description' => 'Micronesia'],
        ['file' => 'moldova', 'description' => 'Moldova'],
        ['file' => 'monaco', 'description' => 'Monaco'],
        ['file' => 'mongolia', 'description' => 'Монгол'],
        ['file' => 'montenegro', 'description' => 'Crna Gora'],
        ['file' => 'morocco', 'description' => 'المغرب'],
        ['file' => 'mozambique', 'description' => 'Moçambique'],
        ['file' => 'myanmar', 'description' => 'Myanmar'],
        ['file' => 'namibia', 'description' => 'Namibia'],
        ['file' => 'nauru', 'description' => 'Nauru'],
        ['file' => 'nepal', 'description' => 'नेपाल'],
        ['file' => 'netherlands', 'description' => 'Nederland'],
        ['file' => 'new_zealand', 'description' => 'New Zealand'],
        ['file' => 'nicaragua', 'description' => 'Nicaragua'],
        ['file' => 'niger', 'description' => 'Niger'],
        ['file' => 'nigeria', 'description' => 'Nigeria'],
        ['file' => 'norway', 'description' => 'Norge'],
        ['file' => 'oman', 'description' => 'عمان'],
        ['file' => 'pakistan', 'description' => 'پاکستان'],
        ['file' => 'palau', 'description' => 'Palau'],
        ['file' => 'palestine', 'description' => 'فلسطين'],
        ['file' => 'panama', 'description' => 'Panamá'],
        ['file' => 'papua_new_guinea', 'description' => 'Papua New Guinea'],
        ['file' => 'paraguay', 'description' => 'Paraguay'],
        ['file' => 'peru', 'description' => 'Perú'],
        ['file' => 'philippines', 'description' => 'Pilipinas'],
        ['file' => 'poland', 'description' => 'Polska'],
        ['file' => 'portugal', 'description' => 'Portugal'],
        ['file' => 'qatar', 'description' => 'قطر'],
        ['file' => 'romania', 'description' => 'România'],
        ['file' => 'russia', 'description' => 'Россия'],
        ['file' => 'rwanda', 'description' => 'Rwanda'],
        ['file' => 'saint_kitts_and_nevis', 'description' => 'Saint Kitts and Nevis'],
        ['file' => 'saint_lucia', 'description' => 'Saint Lucia'],
        ['file' => 'saint_vincent_and_the_grenadines', 'description' => 'Saint Vincent and the Grenadines'],
        ['file' => 'samoa', 'description' => 'Samoa'],
        ['file' => 'san_marino', 'description' => 'San Marino'],
        ['file' => 'sao_tome_and_principe', 'description' => 'São Tomé and Príncipe'],
        ['file' => 'saudi_arabia', 'description' => 'المملكة العربية السعودية'],
        ['file' => 'senegal', 'description' => 'Sénégal'],
        ['file' => 'serbia', 'description' => 'Србија'],
        ['file' => 'seychelles', 'description' => 'Seychelles'],
        ['file' => 'sierra_leone', 'description' => 'Sierra Leone'],
        ['file' => 'singapore', 'description' => 'Singapore'],
        ['file' => 'slovakia', 'description' => 'Slovensko'],
        ['file' => 'slovenia', 'description' => 'Slovenija'],
        ['file' => 'solomon_islands', 'description' => 'Solomon Islands'],
        ['file' => 'somalia', 'description' => 'Soomaaliya'],
        ['file' => 'south_africa', 'description' => 'South Africa'],
        ['file' => 'south_sudan', 'description' => 'South Sudan'],
        ['file' => 'spain', 'description' => 'España'],
        ['file' => 'sri_lanka', 'description' => 'ශ්‍රී ලංකාව'],
        ['file' => 'sudan', 'description' => 'السودان'],
        ['file' => 'suriname', 'description' => 'Suriname'],
        ['file' => 'swaziland', 'description' => 'Swaziland'],
        ['file' => 'sweden', 'description' => 'Sverige'],
        ['file' => 'switzerland', 'description' => 'Schweiz'],
        ['file' => 'syria', 'description' => 'سوريا'],
        ['file' => 'taiwan', 'description' => '台灣'],
        ['file' => 'tajikistan', 'description' => 'Тоҷикистон'],
        ['file' => 'tanzania', 'description' => 'Tanzania'],
        ['file' => 'thailand', 'description' => 'ไทย'],
        ['file' => 'togo', 'description' => 'Togo'],
        ['file' => 'tonga', 'description' => 'Tonga'],
        ['file' => 'trinidad_and_tobago', 'description' => 'Trinidad and Tobago'],
        ['file' => 'tunisia', 'description' => 'تونس'],
        ['file' => 'turkey', 'description' => 'Türkiye'],
        ['file' => 'turkmenistan', 'description' => 'Türkmenistan'],
        ['file' => 'tuvalu', 'description' => 'Tuvalu'],
        ['file' => 'uganda', 'description' => 'Uganda'],
        ['file' => 'ukraine', 'description' => 'Україна'],
        ['file' => 'united_arab_emirates', 'description' => 'United Arab Emirates'],
        ['file' => 'united_kingdom', 'description' => 'United Kingdom'],
        ['file' => 'united_states', 'description' => 'United States'],
        ['file' => 'uruguay', 'description' => 'Uruguay'],
        ['file' => 'uzbekistan', 'description' => 'Oʻzbekiston'],
        ['file' => 'vanuatu', 'description' => 'Vanuatu'],
        ['file' => 'vatican_city', 'description' => 'Vatican City'],
        ['file' => 'venezuela', 'description' => 'Venezuela'],
        ['file' => 'vietnam', 'description' => 'Việt Nam'],
        ['file' => 'yemen', 'description' => 'اليمن'],
        ['file' => 'zambia', 'description' => 'Zambia'],
        ['file' => 'zimbabwe', 'description' => 'Zimbabwe'],
    ];
}