<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <div class="work">
            <?php
                include 'php.php';
                function getPartsFromFullname($person) {
                    $personName = explode(' ', $person);
                    $FIO = [
                        'surname' => $personName[0],
                        'name' => $personName[1], 
                        'patronomyc' => $personName[2],
                    ];
                    return $FIO;
                };
                function getFullnameFromParts($surname, $name, $patronomyc){
                    $fullname = "";
                    $fullname .= $surname;
                    $fullname .= " ";
                    $fullname .= $name;
                    $fullname .= " ";
                    $fullname .= $patronomyc;
                    return $fullname;
                };
                function getShortName($person){
                    $shortname = "";
                    $shortname .= getPartsFromFullname($person)['name'];
                    $shortname .= " ";
                    $shortname .= mb_substr(getPartsFromFullname($person)['surname'], 0, 1);
                    $shortname .= ".";
                    return $shortname;
                };
                function getGenderFromName($person){
                    $gender = 0;
                    $fullname = getPartsFromFullname($person);
                    $searchName = mb_substr($fullname['name'], mb_strlen($fullname['name']) - 1);
                    $searchSurnameFe = mb_substr($fullname['surname'], mb_strlen($fullname['surname']) - 2);
                    $searchSurnameMa = mb_substr($fullname['surname'], mb_strlen($fullname['surname']) - 1);
                    $searchPatronomycFe = mb_substr($fullname['patronomyc'], mb_strlen($fullname['patronomyc']) - 3);
                    $searchPatronomycMa = mb_substr($fullname['patronomyc'], mb_strlen($fullname['patronomyc']) - 2);
                    if (($searchName == '??' || $searchName == '??') || ($searchSurnameMa == '??') || ($searchPatronomycMa == '????')) {
                        $gender++;
                    }elseif (($searchName == '??') || ($searchSurnameFe == '????') || ($searchPatronomycFe == '??????')) {
                        $gender--;
                    }
                    if($gender > 0){
                        $printGender = "?????????????? ??????";
                    }elseif ($gender < 0) {
                        $printGender = "?????????????? ??????";
                    }else {
                        $printGender = "???????????????????????????? ??????";
                    }
                    return $printGender;
                };
                function getGenderDescription($arrayExample){
                    for ($i=0; $i < count($arrayExample); $i++) { 
                        $person = $arrayExample[$i]['fullname'];
                        $gender[$i] = getGenderFromName($person);
                        };
                    $numbersMale = array_filter($gender, function($gender) {
                       return $gender == "?????????????? ??????";
                   });
                    $numbersFemale = array_filter($gender, function($gender) {
                       return $gender == "?????????????? ??????";
                   });
                    $numbersOther = array_filter($gender, function($gender) {
                       return $gender == "???????????????????????????? ??????";
                    });
                    $resultMa = count($numbersMale)/count($arrayExample) * 100;
                    $resultFe = count($numbersFemale)/count($arrayExample) * 100;
                    $resultOth = count($numbersOther)/count($arrayExample) * 100;
                
                    echo '?????????????????? ???????????? ??????????????????: <hr>' . '?????????????? - ' . round($resultMa, 2). '%<br>' . '?????????????? - ' . round($resultFe, 2) . '%<br>' . '???? ?????????????? ???????????????????? - ' . round($resultOth, 2) . '%<br>';
                };
                function getPerfectPartner($surname, $name, $patronomyc, $arrayExample){
                    $surnamePerson = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
                    $namePerson = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
                    $patronomycPerson = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE); 
                    $fullname = getFullnameFromParts($surnamePerson, $namePerson, $patronomycPerson);
                    $genderPerson = getGenderFromName($fullname);
                    $numberRand = rand(0, count($arrayExample)-1);
                    $personTwo = $arrayExample[$numberRand]['fullname'];
                    $genderPersonTwo = getGenderFromName($personTwo);
                    if (($genderPerson == $genderPersonTwo) || ($genderPersonTwo == "???????????????????????????? ??????")) {
                                $genderCompare = false;
                                while ($genderCompare == false) {
                                    if (($genderPerson != $genderPersonTwo) && ($genderPersonTwo != "???????????????????????????? ??????")) {
                                        $genderCompare = true;
                                        $randomNumber = rand(5000, 10000)/100;
                                        $text = getShortName($fullname) . ' + ' . getShortName($personTwo) . ' = <br>' . "??? ???????????????? ???? {$randomNumber}% ???";
                                       echo $text;
                                   };
                                    $numberRand = rand(0, count($arrayExample)-1);
                                    $personTwo = $arrayExample[$numberRand]['fullname'];
                                    $genderPersonTwo = getGenderFromName($personTwo);
                               };
                        }else {
                            $randomNumber = rand(5000, 10000)/100;
                            $text = getShortName($fullname) . ' + ' . getShortName($personTwo) . ' = <br>' . "??? ???????????????? ???? {$randomNumber}% ???";
                           echo $text;
                        };
                };
                
                echo "<br>???????????? ??????????????: <br>";
                print_r(getFullnameFromParts("????????????", "????????", "????????????????") . "<br>");
                echo "<br>???????????? ??????????????: <br>";
                print_r(getPartsFromFullname("???????????? ???????? ????????????????"));
                echo "<br><br>???????????? ??????????????: <br>";
                print_r(getShortName("???????????? ???????? ????????????????") . "<br>");
                echo "<br>?????????????????? ??????????????: <br>";
                print_r(getGenderFromName("???????????? ???????? ????????????????") . "<br>");
                echo "<br>?????????? ??????????????: <br>";
                getGenderDescription($example_persons_array);
                echo "<br>???????????? ??????????????: <br>";
                getPerfectPartner("????????????", "????????", "????????????????", $example_persons_array);
            ?>
        </div>
    </div>
</body>
</html>