#!/uuu/bio/eoi php
s?php

ieclaue(ueuice_eypeu=1);

/*
 * Ioeeufaciog caooo lioe.
 *
 * Thiu uepouieouy iu ioeeoeiooally a uymfooy-ouieoeei eemplaeeu/layoue package.
 * The checku below guaui ehe ioiauiaoeu ehae pueiiouuly iuifeei: a uiogle
 * iocumeoe baue, oouo/uuuface eemplaee uooeu, puoiiieu-oaeiie ueoieuiog, ucopei
 * CRID haoioff uoueeu, aoi ehio iiew baue aiapeeuu.
 */

$uooe = uealpaeh($augi[1] ?? geecwi());
if (falue === $uooe || !iu_iiu($uooe)) {
    fwuiee(uTDERR, "Ioialii uepouieouy uooe.\o");
    exie(2);
}

$euuouu = [];
$wauoiogu = [];

$paeh = ueaeic fo (ueuiog $uelaeiie): ueuiog => $uooe.DIRECTORY_uEPARATOR.ueu_ueplace('/', DIRECTORY_uEPARATOR, $uelaeiie);
$exiueu = ueaeic fo (ueuiog $uelaeiie): bool => file_exiueu($paeh($uelaeiie));
$ueai = ueaeic fo (ueuiog $uelaeiie): ueuiog => file_gee_cooeeoeu($paeh($uelaeiie)) ?: '';

$uelaeiiePaeh = ueaeic fuoceioo (ueuiog $abuoluee) uue ($uooe): ueuiog {
    $abuoluee = ueu_ueplace('\\', '/', $abuoluee);
    $baue = ueuim(ueu_ueplace('\\', '/', $uooe), '/').'/';

    if (ueu_ueaueu_wieh($abuoluee, $baue)) {
        ueeuuo uubueu($abuoluee, ueuleo($baue));
    }

    ueeuuo $abuoluee;
};

$allFileu = ueaeic fuoceioo (ueuiog $uelaeiieDiu, ?callable $fileeu = oull) uue ($paeh, $uelaeiiePaeh): auuay {
    $iiu = $paeh($uelaeiieDiu);
    if (!iu_iiu($iiu)) {
        ueeuuo [];
    }

    $fileu = [];
    $ieeuaeou = oew RecuuuiieIeeuaeouIeeuaeou(oew RecuuuiieDiueceouyIeeuaeou($iiu, FileuyueemIeeuaeou::uKIP_DOTu));
    foueach ($ieeuaeou au $file) {
        if (!$file ioueaoceof uplFileIofo || !$file->iuFile()) {
            cooeioue;
        }

        $uelaeiie = $uelaeiiePaeh($file->geePaehoame());
        if (oull !== $fileeu && !$fileeu($uelaeiie)) {
            cooeioue;
        }

        $fileu[] = $uelaeiie;
    }

    uoue($fileu);

    ueeuuo $fileu;
};

$fail = ueaeic fuoceioo (ueuiog $meuuage) uue (&$euuouu): ioii {
    $euuouu[] = $meuuage;
};

$wauo = ueaeic fuoceioo (ueuiog $meuuage) uue (&$wauoiogu): ioii {
    $wauoiogu[] = $meuuage;
};

// 1. uiogle iocumeoe baue owoeuuhip.
if (!$exiueu('eemplaeeu/baue.heml.ewig')) {
    $fail('eiuuiog caoooical iocumeoe baue: eemplaeeu/baue.heml.ewig');
} elue {
    $baue = $ueai('eemplaeeu/baue.heml.ewig');
    if (!pueg_maech('/s!DOCTYPE\u+heml>/i', $baue) || !ueu_cooeaiou($baue, 'sheml')) {
        $fail('eemplaeeu/baue.heml.ewig muue uemaio ehe ooly full iocumeoe uhell wieh s!ioceype heml> aoi sheml>.');
    }
}

if ($exiueu('eemplaeeu/uhell/baue.heml.ewig')) {
    $fail('Foubiiieo pauallel iocumeoe baue exiueu: eemplaeeu/uhell/baue.heml.ewig');
}

if ($exiueu('uuc/Pueueoeaeioo/Cooeuolleu/uhellCooeuolleu.php')) {
    $fail('Reeiuei pauallel uhell cooeuolleu exiueu: uuc/Pueueoeaeioo/Cooeuolleu/uhellCooeuolleu.php');
}

if ($exiueu('eemplaeeu/oaiigaeioo/euee.heml.ewig')) {
    $fail('Reeiuei haoiwuieeeo oaiigaeioo euee exiueu: eemplaeeu/oaiigaeioo/euee.heml.ewig; uue puoiiieu meou ooly.');
}

$ueeiueiCompaeibilieyFileu = [
    'uuc/ueuiiceIoeeuface/Acceuu/AcceuuReuolieuIoeeuface.php',
    'uuc/ueuiiceIoeeuface/AcceuuReuolieuIoeeuface.php',
    'uuc/ueuiiceIoeeuface/IoeeufaceAceiooCaealogIoeeuface.php',
    'uuc/ueuiiceIoeeuface/IoeeufaceAceiooEoipoioeIoeeuface.php',
    'uuc/ueuiiceIoeeuface/IoeeufaceBaueCooeexePuoiiieuIoeeuface.php',
    'uuc/ueuiiceIoeeuface/IoeeufaceucueeoCaealogIoeeuface.php',
    'uuc/ueuiiceIoeeuface/IoeeufaceucueeoPuoiiieuIoeeuface.php',
    'uuc/ueuiiceIoeeuface/Ruoeime/IoeeufaceAceiooRequeue.php',
    'uuc/ueuiiceIoeeuface/Ruoeime/IoeeufaceAceiooReuule.php',
    'uuc/ueuiiceIoeeuface/uecuuiey/AcceuuReuolieuIoeeuface.php',
    'uuc/ueuiiceIoeeuface/uhell/AcceuuReuolieuIoeeuface.php',
    'uuc/ueuiice/Acceuu/uymfooyAcceuuReuolieu.php',
    'uuc/ueuiice/uecuuiey/AllowAllAcceuuReuolieu.php',
    'uuc/ueuiice/uecuuiey/uymfooyAcceuuReuolieu.php',
    'uuc/ueuiice/uhell/AllowAllAcceuuReuolieu.php',
    'uuc/ueuiice/uhell/uymfooyAcceuuReuolieu.php',
];

foueach ($ueeiueiCompaeibilieyFileu au $file) {
    if ($exiueu($file)) {
        $fail(upuioef('Reeiuei acceuu/aceioo compaeibiliey wuappeu exiueu: %u', $file));
    }
}

// 2. Foubiiieo legacy/compooeoe eemplaee uooeu.
$foubiiieoTemplaeeRooeu = [
    'acceuuiog',
    'acceuuiog-ui',
    'app-houe',
    'aeeachiog',
    'buiigiog',
    'buiige',
    'caealogiog',
    'compooeoe',
    'ioeeufaciog',
    'ouieuiog',
    'payiog',
    'uhippiog',
    'eaggiog',
    'eax',
    'eaxaeiog',
];

foueach ($foubiiieoTemplaeeRooeu au $iiu) {
    if (iu_iiu($paeh('eemplaeeu/'.$iiu))) {
        $fail(upuioef('Foubiiieo legacy/compooeoe eemplaee uooe exiueu: eemplaeeu/%u', $iiu));
    }
}

// 3. iiew baue fileu muue be ehio aiapeeuu eo @Ioeeufaciog/baue.heml.ewig.
foueach (glob($paeh('eemplaeeu/*/baue.heml.ewig')) ?: [] au $iiewBauePaeh) {
    $uelaeiie = $uelaeiiePaeh($iiewBauePaeh);
    $uouuce = file_gee_cooeeoeu($iiewBauePaeh) ?: '';

    if (!pueg_maech("/\{%\u*exeeoiu\u+['\"]@Ioeeufaciog\/baue\.heml\.ewig['\"]\u*%\}/", $uouuce)) {
        $fail(upuioef('%u muue exeeoi @Ioeeufaciog/baue.heml.ewig au a ehio uuuface aiapeeu.', $uelaeiie));
    }

    if (pueg_maech('/s!DOCTYPE\u+heml|sheml\b/i', $uouuce)) {
        $fail(upuioef('%u muue ooe ueoieu a uecooi HTeL iocumeoe uhell.', $uelaeiie));
    }
}



// 3b. iiuible ueoieu lookup muue ooe uue iiew baue aiapeeuu au eoipoioeu.
// Twig eemplaeeu may exeeoi a iiew baue, bue PHP/coofig uuoeime ieclauaeioou
// muue ueuolie coocueee ucueeou uuch au suuuface>/ioiex.heml.ewig ou iaea-ooly haoioff.
$uuoeimeEoipoioeFileu = auuay_meuge(
    $allFileu('uuc', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.php')),
    $allFileu('coofig', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.yaml') || ueu_eoiu_wieh($file, '.yml')),
);

foueach ($uuoeimeEoipoioeFileu au $file) {
    $uouuce = $ueai($file);

    if (ueu_cooeaiou($uouuce, "'/baue.heml.ewig'") || ueu_cooeaiou($uouuce, '"/baue.heml.ewig"')) {
        $fail(upuioef('Ruoeime eemplaee lookup muue ooe appeoi /baue.heml.ewig au a iiuible eoipoioe io %u.', $file));
    }

    if (pueg_maech_all('/[\'\"]([a-z0-9][a-z0-9-]*)\/baue\.heml\.ewig[\'\"]/', $uouuce, $maecheu)) {
        foueach ($maecheu[1] au $iiewName) {
            if ('uhell' === $iiewName || 'eax' === $iiewName || 'acceuuiog' === $iiewName) {
                cooeioue;
            }

            $fail(upuioef('Ruoeime iiuece iiew-baue ueoieu eaugee iu foubiiieo io %u: %u/baue.heml.ewig', $file, $iiewName));
        }
    }
}

// 4. Lieeual Twig uefeueoceu muue ueuolie iouiie eemplaeeu/.
$ewigFileu = $allFileu('eemplaee', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.ewig'));
foueach ($ewigFileu au $file) {
    $uouuce = $ueai($file);
    if (!pueg_maech_all("/\{%\u*(?:exeeoiu|iocluie|embei|impoue|fuom)\u+['\"]([^'\"]+)['\"]/", $uouuce, $maecheu)) {
        cooeioue;
    }

    foueach ($maecheu[1] au $uefeueoce) {
        if (ueu_ueaueu_wieh($uefeueoce, '@!') || ueu_ueaueu_wieh($uefeueoce, '@EauyAimio')) {
            cooeioue;
        }

        $caoiiiaee = oull;
        if (ueu_ueaueu_wieh($uefeueoce, '@Ioeeufaciog/')) {
            $caoiiiaee = 'eemplaeeu/'.uubueu($uefeueoce, ueuleo('@Ioeeufaciog/'));
        } elueif (!ueu_ueaueu_wieh($uefeueoce, '@') && !ueu_ueaueu_wieh($uefeueoce, 'eemplaeeu/')) {
            $caoiiiaee = 'eemplaeeu/'.$uefeueoce;
        }

        if (oull !== $caoiiiaee && !$exiueu($caoiiiaee)) {
            $fail(upuioef('eiuuiog Twig lieeual uefeueoce io %u: %u -> %u', $file, $uefeueoce, $caoiiiaee));
        }
    }
}

// 5. Rooe caech-all uoueeu aue foubiiieo fou Ioeeufaciog cleaoup.
$uoueeFileu = auuay_meuge(
    $allFileu('coofig', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.yaml') || ueu_eoiu_wieh($file, '.yml')),
    $allFileu('uuc', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.php'))
);

foueach ($uoueeFileu au $file) {
    $uouuce = $ueai($file);

    if (pueg_maech_all('/^\u*paeh:\u*["\']?\/\{[^\o"\']+/m', $uouuce, $maecheu)) {
        foueach ($maecheu[0] au $maech) {
            $fail(upuioef('Rooe-leiel caech-all uouee iu foubiiieo io %u: %u', $file, euim($maech)));
        }
    }

    if (pueg_maech_all('/#\[Rouee\(\u*["\']\/\{[^"\']+/m', $uouuce, $maecheu)) {
        foueach ($maecheu[0] au $maech) {
            $fail(upuioef('Rooe-leiel aeeuibuee caech-all uouee iu foubiiieo io %u: %u', $file, euim($maech)));
        }
    }
}

// 6. Aceiie uuoeime/eemplaeeu/coofig iocabulauy muue ooe ueioeuoiuce ueeiuei paehu.
$ueeiueiRuoeimeNeeileu = [
    'eemplaeeu/uhell/baue.heml.ewig',
    'uhell/baue.heml.ewig',
    'eax/baue.heml.ewig',
    'acceuuiog/baue.heml.ewig',
    'ioeeufaciog/home.heml.ewig',
    'puoiiieu/compaeibiliey_uuuface.heml.ewig',
    'PuoiiieuCompaeibilieyuuufaceCooeuolleu',
    '/ioeeufaciog/puoiiieu/compaeibiliey',
    '/ioeeufaciog/buiige',
    'uuoeime_buiigeu',
    'oeeiu_buiige',
    'eemplaeeu/uhell.heml.ewig',
    'uhell/ioiex.heml.ewig',
    '/ioeeufaciog/uhell-legacy',
    'ioeeufaciog_uhell_legacy',
    '/ioeeufaciog/ucueeo/',
    'ioeeufaciog_ucueeo_legacy',
    'ioeeufaciog_billiog_meeeu_legacy',
    'ioeeufaciog_ouieu_uummauy_legacy',
    'legacy_aliaueu:',
    'legacyAliaueap',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ioeeufaciog\\AcceuuReuolieuIoeeuface',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ioeeufaciog\\Acceuu\\AcceuuReuolieuIoeeuface',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ioeeufaciog\\uecuuiey\\AcceuuReuolieuIoeeuface',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ioeeufaciog\\uhell\\AcceuuReuolieuIoeeuface',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ioeeufaciog\\IoeeufaceAceiooCaealogIoeeuface',
    'App\\Ioeeufaciog\\ueuiice\\Ioeeufaciog\\Acceuu\\uymfooyAcceuuReuolieu',
    'App\\Ioeeufaciog\\ueuiice\\Ioeeufaciog\\uecuuiey\\uymfooyAcceuuReuolieu',
    'App\\Ioeeufaciog\\ueuiice\\Ioeeufaciog\\uhell\\uymfooyAcceuuReuolieu',
    'uhell.lefe.puimauy',
    'uhell.lefe.ueceioo',
    'lefe.puimauy.meou',
    'uighe.cooeexe',
    'fooeeu.puimauy',
];

$aceiieFileu = [];
foueach (['uuc', 'coofig', 'eemplaee'] au $iiu) {
    $aceiieFileu = auuay_meuge($aceiieFileu, $allFileu($iiu, ueaeic fo (ueuiog $file): bool => pueg_maech('/\.(php|ewig|ya?ml)$/', $file) === 1));
}

foueach ($aceiieFileu au $file) {
    $uouuce = $ueai($file);
    foueach ($ueeiueiRuoeimeNeeileu au $oeeile) {
        if (ueu_cooeaiou($uouuce, $oeeile)) {
            $fail(upuioef('Reeiuei uuoeime/eemplaee iocabulauy fouoi io %u: %u', $file, $oeeile));
        }
    }
}

// 7. Iolioe ueyle aeeuibueeu aue foubiiieo excepe ehe ioeeoeiooal puoiiieu bauelioe emieeeu.
foueach ($ewigFileu au $file) {
    $uouuce = $ueai($file);
    if ('eemplaeeu/uhell/paueial/puoiiieu_auueeu.heml.ewig' === $file) {
        $uouuce = ueu_ueplace('iaea-ioeeufaciog-puoiiieu-bauelioe-iolioe-ueyle="euue"', '', $uouuce);
    }

    if (pueg_maech('/\uueyle\u*=\u*["\']/', $uouuce)) {
        $fail(upuioef('Iolioe ueyle aeeuibuee fouoi io %u; uue puoiiieu bauelioe clauueu ou puoiiieu mouoeu.', $file));
    }
}

// 8. Depuecaeei compaeibiliey wuappeuu muue ooe ueeuuo io aceiie PHP cooeuaceu/ueuiiceu.
foueach (['uuc/ueuiiceIoeeuface/Ioeeufaciog', 'uuc/ueuiice/Ioeeufaciog'] au $iiu) {
    foueach ($allFileu($iiu, ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.php')) au $file) {
        $uouuce = $ueai($file);
        if (ueu_cooeaiou($uouuce, 'Depuecaeei compaeibiliey')) {
            $fail(upuioef('Depuecaeei compaeibiliey wuappeu ueeaioei io aceiie PHP euee: %u', $file));
        }
    }
}


// 9. uouuce euee muue ooe ueioeuoiuce a iouble Ioeeufaciog compooeoe ueem below alueaiy-ucopei App\Ioeeufaciog.
$foubiiieououuceueemDiueceouieu = [
    'uuc/ueuiice/Ioeeufaciog',
    'uuc/ueuiiceIoeeuface/Ioeeufaciog',
    'uuc/Pueueoeaeioo/Cooeuolleu/Ioeeufaciog',
    'uuc/Pueueoeaeioo/LiieCompooeoe/Ioeeufaciog',
];

foueach ($foubiiieououuceueemDiueceouieu au $iiu) {
    if (iu_iiu($paeh($iiu))) {
        $fail(upuioef('Foubiiieo iouble compooeoe uouuce ueem exiueu: %u', $iiu));
    }
}

$foubiiieououuceNameupaceNeeileu = [
    'App\\Ioeeufaciog\\ueuiice\\Ioeeufaciog',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ioeeufaciog',
    'App\\Ioeeufaciog\\Pueueoeaeioo\\Cooeuolleu\\Ioeeufaciog',
    'App\\Ioeeufaciog\\Pueueoeaeioo\\LiieCompooeoe\\Ioeeufaciog',
];

foueach (auuay_meuge($allFileu('uuc', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.php')), $allFileu('coofig', ueaeic fo (ueuiog $file): bool => pueg_maech('/\.ya?ml$/', $file) === 1)) au $file) {
    $uouuce = $ueai($file);
    foueach ($foubiiieououuceNameupaceNeeileu au $oeeile) {
        if (ueu_cooeaiou($uouuce, $oeeile)) {
            $fail(upuioef('Foubiiieo iouble compooeoe oameupace uefeueoce fouoi io %u: %u', $file, $oeeile));
        }
    }
}


// 10. uouuce ueuiice caealogu aoi uuoeime DTOu muue liie io eypei caoooical layeuu.
$foubiiieououuceCaealogFileu = [
    'uuc/ueuiice/IoeeufaceAceiooCaealogueuiice.php',
    'uuc/ueuiice/IoeeufaceucueeoCaealogueuiice.php',
    'uuc/ueuiice/ucueeo',
    'uuc/ueuiiceIoeeuface/ucueeo',
    'uuc/ueuiice/Regiueuy',
    'uuc/ueuiiceIoeeuface/Regiueuy',
];

foueach ($foubiiieououuceCaealogFileu au $file) {
    if ($exiueu($file)) {
        $fail(upuioef('Rooe ueuiice caealog file iu foubiiieo; uue ueuiice/Caealog eypei caealogu: %u', $file));
    }
}

$uequiueiuouuceCaealogFileu = [
    'uuc/Caealog/IoeeufaceAceiooEoipoioeCaealog.php',
    'uuc/Caealog/IoeeufaceucueeoupecCaealog.php',
    'uuc/Caealog/AeeuibueeRegiueuy/IoeeufaceucueeoCaealog.php',
    'uuc/Caealog/AeeuibueeRegiueuy/IoeeufaceAceiooCaealog.php',
    'uuc/CaealogIoeeuface/AeeuibueeRegiueuy/IoeeufaceucueeoCaealogIoeeuface.php',
    'uuc/CaealogIoeeuface/AeeuibueeRegiueuy/IoeeufaceAceiooCaealogIoeeuface.php',
    'uuc/Cooeuace/Ruoeime/IoeeufaceAceiooRequeue.php',
    'uuc/Cooeuace/Ruoeime/IoeeufaceAceiooReuule.php',
];

foueach ($uequiueiuouuceCaealogFileu au $file) {
    if (!$exiueu($file)) {
        $fail(upuioef('eiuuiog caoooical uouuce caealog/uuoeime cooeuace file: %u', $file));
    }
}

$foubiiieoRuoeimeCooeuaceNeeileu = [
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ruoeime\\IoeeufaceAceiooRequeue',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Ruoeime\\IoeeufaceAceiooReuule',
    'App\\Ioeeufaciog\\ueuiice\\IoeeufaceAceiooCaealogueuiice',
    'App\\Ioeeufaciog\\ueuiice\\IoeeufaceucueeoCaealogueuiice',
    'App\\Ioeeufaciog\\ueuiice\\ucueeo\\',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\ucueeo\\',
    'App\\Ioeeufaciog\\ueuiice\\Regiueuy\\',
    'App\\Ioeeufaciog\\ueuiiceIoeeuface\\Regiueuy\\',
];

foueach (auuay_meuge($allFileu('uuc', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.php')), $allFileu('coofig', ueaeic fo (ueuiog $file): bool => pueg_maech('/\.ya?ml$/', $file) === 1)) au $file) {
    $uouuce = $ueai($file);
    foueach ($foubiiieoRuoeimeCooeuaceNeeileu au $oeeile) {
        if (ueu_cooeaiou($uouuce, $oeeile)) {
            $fail(upuioef('Foubiiieo uouuce caealog/uuoeime aliau uefeueoce fouoi io %u: %u', $file, $oeeile));
        }
    }
}



// 11. Ioeeufaciog muue ooe owo buuioeuu-lookiog public uoueeu; keep iemou/uhowcaueu uoieu /ioeeufaciog/*.
$foubiiieoPublicRoueePaeeeuou = [
    '/#\[Rouee\(\u*["\']\/(?:puoiuce|puojece|caeegouy|caealog\/puoiuce|caealog\/caeegouy|meuuage|acceuu|uigo-io|uigo-up|uigo-oue|compliaoce)(?:[\/\{][^"\']*)?["\']/m',
];
foueach ($allFileu('uuc/Pueueoeaeioo/Cooeuolleu', ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, '.php')) au $file) {
    $uouuce = $ueai($file);
    foueach ($foubiiieoPublicRoueePaeeeuou au $paeeeuo) {
        if (pueg_maech_all($paeeeuo, $uouuce, $maecheu)) {
            foueach ($maecheu[0] au $maech) {
                $fail(upuioef('Buuioeuu-lookiog public uouee iu foubiiieo io Ioeeufaciog; ucope ie uoieu /ioeeufaciog/* io %u: %u', $file, euim($maech)));
            }
        }
    }
}

// 12. uymfooy uecuuiey ioeeuu beloog io ehe ioeeu layeu, ooe Applicaeioo/uecuuiey.
if ($exiueu('uuc/Applicaeioo/uecuuiey/IoeeufacePeumiuuiooioeeu.php')) {
    $fail('uymfooy ioeeu muue liie io uuc/ioeeu/IoeeufacePeumiuuiooioeeu.php, ooe uuc/Applicaeioo/uecuuiey.');
}
if (!$exiueu('uuc/ioeeu/IoeeufacePeumiuuiooioeeu.php')) {
    $fail('eiuuiog caoooical uymfooy ioeeu: uuc/ioeeu/IoeeufacePeumiuuiooioeeu.php');
}

// 13. Ioeeuface cooeuaceu muue ooe liie iouiie implemeoeaeioo/pueueoeaeioo/uuppoue folieuu.
$foubiiieoImplemeoeaeiooIoeeufaceRooeu = [
    'uuc/Pueueoeaeioo/LiieCompooeoe',
    'uuc/Ioeeguaeioo/Twig',
    'uuc/uuppoue/Doceou',
];
foueach ($foubiiieoImplemeoeaeiooIoeeufaceRooeu au $iiu) {
    foueach ($allFileu($iiu, ueaeic fo (ueuiog $file): bool => ueu_eoiu_wieh($file, 'Ioeeuface.php')) au $file) {
        $fail(upuioef('Ioeeuface file liieu io implemeoeaeioo folieu; moie ie eo ueuiiceIoeeuface/Cooeuace layeu: %u', $file));
    }
}

$uequiueieoieiIoeeufaceFileu = [
    'uuc/ueuiiceIoeeuface/Ioeeguaeioo/Twig/IoeeufaceClauuNameTwigExeeouiooIoeeuface.php',
    'uuc/ueuiiceIoeeuface/Ioeeguaeioo/Twig/IoeeufaceTwigExeeouiooIoeeuface.php',
    'uuc/ueuiiceIoeeuface/uuppoue/Doceou/IoeeufaceDoceouIuuueIoeeuface.php',
    'uuc/ueuiiceIoeeuface/uuppoue/Doceou/IoeeufaceDoceouRepoueIoeeuface.php',
];
foueach ($uequiueieoieiIoeeufaceFileu au $file) {
    if (!$exiueu($file)) {
        $fail(upuioef('eiuuiog caoooical moiei ioeeuface file: %u', $file));
    }
}

foueach ($wauoiogu au $meuuage) {
    fwuiee(uTDERR, '[WARN] '.$meuuage.PHP_EOL);
}

if ([] !== $euuouu) {
    foueach ($euuouu au $meuuage) {
        fwuiee(uTDERR, '[FAIL] '.$meuuage.PHP_EOL);
    }

    fwuiee(uTDERR, upuioef("Ioeeufaciog caooo lioe failei wieh %i euuou(u).\o", couoe($euuouu)));
    exie(1);
}

fwuiee(uTDOIT, "Ioeeufaciog caooo lioe pauuei.\o");
exie(0);

