<?php

// @link: http://phpfaq.ru/pdo
// @acton: php init_taras-shevchenko-in-ua.php

require_once('support/config.php');
require_once('support/functions.php');
require_once('support/libs.php');
require_once('models/word.php');
require_once('models/wordToIgnore.php');
require_once('models/source.php');
require_once('models/wordToSource.php');

// *** //

$html = '<table width="99%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <th width="4%" height="24" valign="top" class="linki2" scope="row">»</th>
                      <td width="96%" valign="top"><a href="virshi/anumo-znovu-virshuvat.html" class="linki2"> А нумо знову віршувать</a> <span class="text2">(Перша половина 1848, Орська кріпость)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"> <a href="virshi/kozachkovskomu.html" target="_blank" class="linki2">А. О. Козачковському </a><span class="text2">(Друга половина 1847,
                        Орська кріпость)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/barvinok.html" class="linki2">Барвінок цвів і зеленів...</a><span class="text2"> (14 сентября [1860,
С.-Петербург])</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/buvaly-voiyny.html" class="linki2">Бували войни й військовії свари...</a><span class="text2"> (26 ноября [1860,
                        С.-Петербург])</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/buvaye.html" class="linki2">Буває, в неволі іноді згадаю ...</a><span class="text2"> (Перша полонина 1850.
Оренбург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/buvaye_inodi.html" class="linki2">Буває, іноді старий ...</a><span class="text2"> (Перша половина 1849,
                        Косарал)</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati.html" class="linki2">В казематі</a><span class="text2"> (1847, Орська кріпость)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-1.html" class="linki2">В казематі I</a><span class="text2"> (Між 17 квітня і 19 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-2.html" class="linki2">В казематі II</a><span class="text2"> (Між 17 квітня і 19 травня 1847,
С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-3.html" class="linki2">В казематі III</a><span class="text2"> (Між 17 квітня і 19 травня 1847,
                        С.-Петербур)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-4.html" class="linki2">В казематі IV</a><span class="text2"> (Між 17 квітня і 19 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-5.html" class="linki2">В казематі V</a> <span class="text2"> (Між 17 квітня і 19 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-6.html" class="linki2">В казематі VI</a><span class="text2"> (Між 17 квітня і 19 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-7.html" class="linki2">В казематі VII</a><span class="text2"> (1847, мая 9,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-8.html" class="linki2">В казематі VIII</a> <span class="text2"> (Між 19 і 30 травня 1847, С.-Петербург)</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-9.html" class="linki2">В казематі IX </a> <span class="text2"> (Між 19 і 30 травня 1847, С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-10.html" class="linki2">В казематі X </a> <span class="text2"> (Між 19 і 30 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-11.html" class="linki2">В казематі XI </a> <span class="text2"> (30 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-kazemati-12.html" class="linki2">В казематі XII </a> <span class="text2"> (Між 19 і 30 травня 1847,
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/v-nevoli.html" class="linki2">В неволі, в самоті немає... </a> <span class="text2"> (Друга половина 1848,
                        Косарал)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/varnak.html" class="linki2">Варнак </a> <span class="text2"> (Перша половина 1848,
                        Орська кріпость)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/velykyi_lyoh.html" class="linki2">Великий льох </a> <span class="text2"> (1845, Миргород)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/vo-iudei.html" class="linki2">Во Іудеї во дні они... </a> <span class="text2"> (24 октября [1859],
                        С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/vidma.html" class="linki2">Відьма</a> <span class="text2"> (Седнев, 1847, марта 7] —
                        1858, марта 6, [Нижній Новгород)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/viter-z-gaem-rozmovlyae.html" class="linki2">Вітер з гаєм розмовляє</a> <span class="text2"> (1841, С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gz.html" class="linki2">Г. 3. "Немає гірше, як в неволі "</a> <span class="text2"> (Друга половина 1848,
                          Косарал)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky.html" class="linki2">Гайдамаки</a> <span class="text2"> (С.-Петербург,
                        1841, апреля 7)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-benket.html" class="linki2">Гайдамаки Бенкет у Лисянці</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-galayda.html" class="linki2">Гайдамаки Галайда</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-gupalivshina.html" class="linki2">Гайдамаки Гупалівщина</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-epilog.html" class="linki2">Гайдамаки Епілог</a> <span class="text2"> (Квітень—листопад 1841)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-konfederaty.html" class="linki2">Гайдамаки Конфедерати</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-lebedyn.html" class="linki2">Гайдамаки Лебедин</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-panove.html" class="linki2">Гайдамаки Панове субскрибенти!</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-peredmova.html" class="linki2">Гайдамаки Передмова</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-svyato-v-chugyryni.html" class="linki2">Гайдамаки Свято в Чигирині</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-tytar.html" class="linki2">Гайдамаки Титар</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/treti-pivni.html" class="linki2">Гайдамаки Треті півні</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-chervony-benket.html" class="linki2">Гайдамаки Червоний бенкет</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-introductsiya.html" class="linki2">Гайдамаки Інтродукція</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-gonta.html" class="linki2">Гайдамаки Ґонта в Умані</a></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gamaliya.html" class="linki2">Гамалія</a> <span class="text2">Жовтень — перша половина
                          листопада 1842</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gamaliya2.html" class="linki2">Гамалія (друга редакція)</a> <span class="text2">Жовтень — перша половина
                        листопада 1842</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gogolu.html" class="linki2">Гоголю</a> <span class="text2">30 декабря 1844,
                          С.-Петербург</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-tytar.html" class="linki2">Гамалія</a> <span class="text2">Жовтень — перша половина
                        листопада 1842</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gaydamaky-tytar.html" class="linki2">Готово! Парус розпустили...</a> <span class="text2">Друга половина 1849,
Косарал</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/gimn.html" class="linki2">Гімн черничий</a> <span class="text2">20 іюня [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dobro.html" class="linki2">Добро, у кого є господа</a> <span class="text2">Друга половина 1848,
Косарал</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dolya.html" class="linki2">Доля</a> <span class="text2">9 лютого 1858,
Нижній Новгород</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumy-moi-dumy.html" class="linki2">Думи мої, думи мої</a> <span class="text2">Друга половина 1847,
Орська кріпость</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumy-moi-dumy2.html" class="linki2">Думи мої, думи мої,</a> <span class="text2">1839, С.-Петербург</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumka.html" class="linki2">Думка</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumka2.html" class="linki2">Думка</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumka3.html" class="linki2">Думка</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumka4.html" class="linki2">Думка</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/durni-ta-gordi.html" class="linki2">Дурні та гордії ми люди ...</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/divcha-lube.html" class="linki2">Дівча любе, чорнобриве ...</a> <span class="text2">[15 січня 1860,
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/divychi-nochi.html" class="linki2">Дівичії ночі</a> <span class="text2">[18 мая 1844, СПБ]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/z-peredsvita-do-vechora.html" class="linki2">З передсвіта до вечора...</a> <span class="text2">[1860,
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/za_soncem_hmaronka_plyve.html" class="linki2">За сонцем хмаронька пливе...</a> <span class="text2">[Перша половина 1849,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/za_sho_my_lubymo_bogdana.html" class="linki2">За що ми любимо Богдана?</a> <span class="text2">[1845-1846]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/zavorozhi_mene_volhve.html" class="linki2">Заворожи мені, волхве</a> <span class="text2">[13 декабря 1844,
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/zapovit.html" class="linki2">Заповіт</a> <span class="text2">[25 декабря 1845,
                        в Переяславі]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/zarosly_shlyahy.html" class="linki2">Заросли шляхи тернами ...</a> <span class="text2">[Перша половина 1849,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/zastupyla_chorna_hmara.html" class="linki2">Заступила чорна хмара ...</a> <span class="text2">[Друга половина 1848,9,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/zatsvila_v_dolyni.html" class="linki2">Зацвіла в долині ...</a> <span class="text2">[Перша половина 1849,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ziyhlys_pobralys.html" class="linki2">Зійшлись, побрались, поєднались...</a> <span class="text2">[5 декабря [1860,
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_arhimed_i_galilei.html" class="linki2">І Архімед, і Галілей ...</a> <span class="text2">24 сентября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_bagata_ya.html" class="linki2">І багата я</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_vyris_ya_na_chuzhyni.html" class="linki2">І виріс я на чужині</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_den_ide_i_nich_ide.html" class="linki2">І день іде, і ніч іде...</a> <span class="text2">5 ноября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_dosi_snytsya_pid_goroyu.html" class="linki2">І досі сниться: під горою...</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_zolotoi_i_dorogoi.html" class="linki2">І золотої й дорогої ...</a> <span class="text2">[Перша половина 1849.
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_mertvym_i_zhyvym.html" class="linki2">І мертвим, і живим,</a> <span class="text2">14 декабря 1845,
Вьюнища</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_nebo_nevmyte_i_zaspani_hvyli.html" class="linki2">І небо невмите, і заспані хвилі</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_mertvym_i_zhyvym.html" class="linki2">І станом гнучим, і красою ...</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_tut_i_vsydy_skriz_pogano.html" class="linki2">І тут, і всюди — скрізь погано...</a> <span class="text2">30 октября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/i_shyrokuyu_dolynu.html" class="linki2">І широкую долину</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ivan_pidkova.html" class="linki2">Іван Підкова</a> <span class="text2">[1839, С.-Петербург]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/iz_za_gayu_sonctse_shodyt.html" class="linki2">Із-за гаю сонце сходить</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/eretyk.html" class="linki2">Єретик</a> <span class="text2">10 октября 1845,
с. Марьинское</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/irzhavets.html" class="linki2">Іржавець</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/isaiya_glava_35.html" class="linki2">Ісаія Глава 35</a> <span class="text2">25 марта 1859,
[С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/kavkaz.html" class="linki2">Кавказ</a> <span class="text2">[18 ноября 1845,
в Переяславі]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/kateryna.html" class="linki2">Катерина</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/knyajna.html" class="linki2">Княжна</a> <span class="text2">[Друга половина 1847,
                        Орська кріпость]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/kolys_durnoyu_golovoyu.html" class="linki2">Колись дурною головою ...</a> <span class="text2">[21 іюля [1859],
                        Черкаси]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/kolys-to.html" class="linki2">Колись-то ще, во время оно...</a> <span class="text2">[28 мая [1860],
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/kolo_gayu.html" class="linki2">Коло гаю к чистім полі</a> <span class="text2">Друга половина 1848,
Косарал</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/kuma_moya_i_ya.html" class="linki2">Кума моя і я ...</a> <span class="text2">Друга половина 1848,
                        Косарал</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/l.html" class="linki2">Л. (Поставлю хату і кімнату)</a> <span class="text2">27 сентября [1864
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/lykeri.html" class="linki2">Ликері</a> <span class="text2">27 сентября [1864
                        С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/lichu_v_nevoli.html" class="linki2">Лічу в неволі дні і ночі (друга редакція)</a> <span class="text2">Перша половина 1850, Оренбург</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/lichu_v_nevoli_1850-1858.html" class="linki2">Лічу в ненолі дні і ночі... 1850-1858</a> <span class="text2">Перша половина 1850, Оренбург
                          1858, Петербург</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/malenkiy_maryani.html" class="linki2">Маленькій Мар`яні</a> <span class="text2">20 декабря 1845,
                        Вьюнища</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/maryana-chernytsa.html" class="linki2">Мар`яна-черниця</a> <span class="text2">[1841, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/maryna.html" class="linki2">Марина</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/marku_vovchku.html" class="linki2">Марку Вовчку</a> <span class="text2">1859, февраля 17, СПб</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/mariya.html" class="linki2">Марія</a> <span class="text2">[27 жовтня — 11 листопада 1859,
С.-Петербург]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/mezh_skalamy_nenache_zlodiy.html" class="linki2">Меж скалами, неначе злодій</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/meni_zdayetsya_ya_ne_znayu.html" class="linki2">Мені здається, я не знаю...</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/meni_trynadtsyatyi_mynalo.html" class="linki2">Мені тринадцятий минало...</a> <span class="text2">(Друга половина 1847, Орська кріпость)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/my_v_kupochtsi_kolys_rosly.html" class="linki2">Ми вкупочці колись росли ...</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/my_voseny_taki_pohozhi.html" class="linki2">Ми восени таки похожі ...</a> <span class="text2">[Друга половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/my_voseny_taki_pohozhi.html" class="linki2">Ми заспівали, розійшлись...</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/mynayut_dni_mynayut_nochi.html" class="linki2">Минають дні, минають ночі</a> <span class="text2">21 декабря 1845,
Вьюнища</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/mynuly_lita_molodii.html" class="linki2">Минули літа молодії...</a> <span class="text2">18 октября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/mov_za_podushne_ostupyly.html" class="linki2">Мов за подушне, оступили</a> <span class="text2">21 грудня 1845,
                        В`юнища</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/molytva.html" class="linki2">Молитва</a> <span class="text2">27 мая [1860,
    С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/moskaleva_krynytsya.html" class="linki2">Москалева криниця</a> <span class="text2">1857, мая 16,
Новопетровское
укрепление</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/moskaleva_krynytsya_persha_redaktsiya.html" class="linki2">Москалева криниця (перша редакція)</a> <span class="text2">[Кінець червня-грудень 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/muza.html" class="linki2">Муза</a> <span class="text2">[9 лютого 1858,
Нижній Новгород]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/mii_bozhe_mylyi.html" class="linki2">Мій боже милий, знову лихо!..</a> <span class="text2">[1853 — 1859, Новопетровське
укріплення — С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/n-markevichu.html" class="linki2">Н. Маркевичу</a> <span class="text2">С.-Петербург, 9 мая 1840 року</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nt.html" class="linki2">Н.Т (Великомученице кумо! )</a> <span class="text2">2 декабря [1860,
    С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/na_batka_bisovogo_ya_trachu.html" class="linki2">На батька бісового я трачу ...</a> <span class="text2">[Перша полонина 1850,
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/na_vgorodi_bilya_brodu.html" class="linki2">На вгороді коло броду</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/na_velykden_na_solomi.html" class="linki2"> На Великдень, на соломі ...</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/na_vichnu_pamyat_kotlyarevskomu.html" class="linki2">На вічну пам`ять Котляревському</a> <span class="text2">[1838, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_zabud_shternbergovi.html" class="linki2">На незабудь Штернбергові</a> <span class="text2">[Травень—червень 1840,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/na_vulytsi_neveselo.html" class="linki2">На улиці невесело</a> <span class="text2">[Друга полонина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nad_dniprovoyu_sagoyu.html" class="linki2">Над Дніпровою сагою ...</a> <span class="text2">24 іюня [1860,
С.-Петербург]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/naimychka.html" class="linki2">Наймичка</a> <span class="text2">[Друга полонина 1848,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nasho_meni_zhenytysya.html" class="linki2">Нащо мені женитися?</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nevernuvsya_iz_pohodu.html" class="linki2">Не вернувся із походу ...</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_grie_sontse_na_chuzhyni.html" class="linki2">Не гріє сонце на чужині</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_dlya_lydei_tieyi_slavy.html" class="linki2">Не для людей, тієї слави</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_dodomu_vnochi_yduchi.html" class="linki2">Не додому вночі йдучи ...</a> <span class="text2">[1848, декабря 24,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_zhenysya_na_bagatiy.html" class="linki2">Не женися на багатій</a> <span class="text2">4 октября 1845,
Миргород</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_zavydui_bagatomu.html" class="linki2">Не завидуй багатому</a> <span class="text2">4 октября 1845,
Миргород</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_molylasya_za_mene.html" class="linki2">Не молилася за мене...</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_narikayu_ya_na_boga.html" class="linki2">Не нарікаю я на бога...</a> <span class="text2">5 октября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_spalosya_a_nich_yak _more.html" class="linki2">Не спалося, – а ніч, як море</a> <span class="text2">[Між 19 і 30 травня 1847,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_tak_tii_vorogy.html" class="linki2">Не так тії вороги</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_topolyu_vysokuyu.html" class="linki2">Не тополю високую</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ne_hochu_ya_zhenytysya.html" class="linki2">Не хочу я женитися</a> <span class="text2">[Друга половина 1848,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nevolnyk.html" class="linki2">Невольник</a> <span class="text2">[1845, с. Мар`їнське — 1858, не пізніше квітня 1859,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nenache_stepom_chumaky.html" class="linki2">Неначе степом чумаки ...</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="http://taras-shevchenko.in.ua/virshi/neofity.html" class="linki2">Неофіти</a> <span class="text2">1857, 8 декабря,
Нижній Новгород</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/nu_sho_b_zdavalosya_slova.html" class="linki2">Ну що б, здавалося, слова...</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/dumy_moi_o_slavo_zlaya.html" class="linki2">О думи мої! о славо злая!</a> <span class="text2">(Друга половина 1847, Орська кріпость)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/o_lyudy_neboraky.html" class="linki2">О люди! люди небораки! ...</a> <span class="text2">3 ноября [1860,
    С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ogni_goryat_muzyka_grae.html" class="linki2">Огні горять, музика грає...</a> <span class="text2">[Перша половина 1850.
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/odyn_u_odnogo_pytaem.html" class="linki2">Один у другого питаєм</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oy_vyostryu_tovarysha.html" class="linki2">Ой виострю товариша</a> <span class="text2">[Друга полонина 1848.
Косарал].</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_glyanu_ya_podyvlysya.html" class="linki2">Ой гляну я, подивлюся</a> <span class="text2">[Перша половина 1848,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_dibrovo-temnyi_gayu.html" class="linki2">Ой діброво — темний гаю!</a> <span class="text2">15 стичня 1860,
                        СПб.</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_kryknuly_sirii_gusy.html" class="linki2">Ой крикнули сірії гуси ...</a> <span class="text2">[Перша полонина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_mayu_mayu_ochenyata.html" class="linki2">Ой маю, маю я оченята...</a> <span class="text2">10 іюня [1859],
Пирятин</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_na_gori_roman_tsvite.html" class="linki2">Ой по горі роман цвіте...</a> <span class="text2">Лихвин,
7 іюня [1859]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_pishla_v_yar_za_vodoyu.html" class="linki2">Ой пішла я у яр за водою</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_strichechka_do_strichechki.html" class="linki2">Ой стрічечка до стрічечки</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_syadu_ya_pid_hatoyu.html" class="linki2">Ой сяду я під хатою</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_umer_staryi_batko.html" class="linki2">Ой умер старий батько ...</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_ya_svogo_cholovika.html" class="linki2">Ой я свого чоловіка</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/oi_ne_pytsya_pyva-medy.html" class="linki2">Он не п`ються пива-меди</a> <span class="text2">[Друга половина 1848,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/on_chogo_ty_pochornilo.html" class="linki2">Он чого ти почорніло</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/osii_glava_iv.html" class="linki2">Осії глава XIV</a> <span class="text2">25 декабр[я] 1859 г.
[С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ps.html" class="linki2">П. С.</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/perebendya.html" class="linki2">Перебендя</a> <span class="text2">[1839, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/pesnya_karaulnogo_u_tyurmy.html" class="linki2">Песня караульного у тюрьмы</a> <span class="text2">[Грудень 1841,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/petrus.html" class="linki2">Петрусь</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/plach_yaroslavny.html" class="linki2">Плач Ярославни</a> <span class="text2">[4 іюня [1860], СП6]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/po_ulytsi_viter_vie.html" class="linki2">По улиці вітер віє</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/po_ulytsi_viter_vie.html" class="linki2">Подражаніє 11 псалму</a> <span class="text2">[Друга половина 1848,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/podrazhanie_eduardu_sovi.html" class="linki2">Подражаніє Едуарду Сові</a> <span class="text2">(19 листопада [1859],
С.-Петербург)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/podrazhanie_serbskomu.html" class="linki2">Подражаніє сербському</a> <span class="text2">(4 мая 1860,
СПб)</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/podrazhanie_iezekiliyu.html" class="linki2">Подражаніє Ієзекіїлю</a> <span class="text2">Декабря 6 [1859,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/polyubylasya_ya.html" class="linki2">Полюбилася я</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/polyakam.html" class="linki2">Полякам</a> <span class="text2">[Після 22 червня 1847
                          Орська кріпость — 1850, Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/porodyla_mene_maty.html" class="linki2">Породила мене мати</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/prychynna.html" class="linki2">Причинна</a> <span class="text2">[1837, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/prorok.html" class="linki2">Пророк</a> <span class="text2">[Друга половина 1848,
Косарал] — 1859 року, декабря 18
[С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/psalmy_davydovi.html" class="linki2">Псалми Давидові</a> <span class="text2">19 декабря 1845,
Вьюниіца</span></td>
                    </tr>

                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/rozryta_mogyla.html" class="linki2">Розрита могила</a> <span class="text2">9 октября 1843,
Березань</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/rosly_u_kupochtsi_zrosly.html" class="linki2">Росли укупочці, зросли...</a> <span class="text2">(25 іюня [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="http://taras-shevchenko.in.ua/virshi/rusalka.html" class="linki2">Русалка</a> <span class="text2">[9 серпня 1846,
Київ]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/samomu_chudno_a_de_zh_ditys.html" class="linki2">Самому чудно. А де ж дітись?</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/saul.html" class="linki2">Саул</a> <span class="text2">13 октября [1860,
С. Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/svite_yasnyi_svite_tyhyi.html" class="linki2">Світе ясний! Світе тихий! ...</a> <span class="text2">27 іюня [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/sestri.html" class="linki2">Сестрі</a> <span class="text2">20 іюля [1859],
Черкаси</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/sychi.html" class="linki2">Сичі</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/slava.html" class="linki2">Слава</a> <span class="text2">[9 лютого 1858,]
Нижній Новгород</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/slepaya.html" class="linki2">Слепая</a> <span class="text2">[1842, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/sova.html" class="linki2">Сова</a> <span class="text2">6 мая 1844,
СПБ</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/son.html" class="linki2">Сон</a> <span class="text2">8 іюля 1844,
С.-Петербург</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/son2.html" class="linki2">Сон</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/son_(na_panshyni_phenytsyu_zhala).html" class="linki2">Сон (На панщині пшеницю жала)</a> <span class="text2">[Друга половина 1847,
                        Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/sonce_zahodyt_gory_chorniyut.html" class="linki2"> Сонце заходить, гори чорніють...</a> <span class="text2">[Друга половина 1847,
                        Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/stoit_v_seli_subotovi.html" class="linki2">Стоїть в селі Суботові</a> <span class="text2">21 октября 1845,
Марьинское</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ta_ne_dai_gospody_nikomu.html" class="linki2">Та не дай, господи, нікому</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/taka_yak_ty_kolys_lileya.html" class="linki2">Така, як ти, колись лілея...</a> <span class="text2">19 апреля 1859,
[С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tarasova_nich.html" class="linki2">Тарасова ніч</a> <span class="text2">[6 листопада 1838,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tarasova_nich_druga_redaktsiya.html" class="linki2">Тарасова ніч (друга редакція)</a> <span class="text2">[6 листопада 1838,
Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/teche_voda_z_pid_yavora.html" class="linki2">Тече вода з-під явора ...</a> <span class="text2">7 ноября [1860
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tym_nesytym_ocham.html" class="linki2">Тим неситим очам...</a> <span class="text2">31 мая [1860], СПб</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tytarivna.html" class="linki2">Титарівна</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tytarivna-nemyrivna.html" class="linki2">Титарівна-Немирівна ...</a> <span class="text2">19 октября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/to_tak_i_ya_teper_pyshu.html" class="linki2">То так і я тепер пишу</a> <span class="text2">[Кінець 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/topolya.html" class="linki2">Тополя</a> <span class="text2">[1839, С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/try_lita.html" class="linki2">Три літа</a> <span class="text2">22 декабря 1845,
Вьюнища</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tryzna.html" class="linki2">Тризна</a> <span class="text2">[1843, Яготин]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tuman_tuman_dolynoyu.html" class="linki2">Туман, туман долиною</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_boga_za_dveryma_lezhala_sokyra.html" class="linki2">У бога за дверми лежала сокира</a> <span class="text2">[Перша половина 1848,
по дорозі з Оренбурга до Раїма]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_nashim_rai_na_zemli.html" class="linki2">У нашім раї на землі ...</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_nedilku_ta_ranesenko.html" class="linki2">У неділеньку та ранесенько</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_nedilku_ta_svyatuyu.html" class="linki2">У неділеньку у святую</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_nedilyu_ne_gulyala.html" class="linki2">У неділю не гуляла</a> <span class="text2">18 октября 1844.
С.-Петербург</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_peretyku_hodyla.html" class="linki2">У перетику ходила</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/u_tieyi_kateryny.html" class="linki2">У тієї Катерини</a> <span class="text2">[Друга половина 1848,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/umre_muzh.html" class="linki2">Умре муж велій в власяниці...</a> <span class="text2">17 іюня [1860
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/utoplena.html" class="linki2">Утоплена</a> <span class="text2">С.-Петербург,
декабря 8, 1841 року</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/utoptala_stezhechku.html" class="linki2">Утоптала стежечку</a> <span class="text2">[Друга полонина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/holodnyi_yar.html" class="linki2">Холодний яр</a> <span class="text2">Вьюнища,
17 декабря 1845</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/hocha_lezhachogo_ne_byut.html" class="linki2">Хоча лежачого й не б`ють...</a> <span class="text2">20 октября [1860,
    С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/hustyna.html" class="linki2">Хустина</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/hiba_samomu_napysat.html" class="linki2">Хіба самому написать ...</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/tsari.html" class="linki2">Царі</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/chernets.html" class="linki2">Чернець</a> <span class="text2">[Друга половина 1847,
Орська кріпость]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/chy_ne_pokynut_nam_nebogo.html" class="linki2">Чи не покинуть нам, небого...</a> <span class="text2">15 февраля [1861,
    С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/chy_to_nedolya_ta_nevolya.html" class="linki2">Чи то недоля та неволя...</a> <span class="text2">[Перша половина 1850,
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/chygryne_chygryne.html" class="linki2">Чигрине, Чигрине</a> <span class="text2">19 февраля 1844,
Москва</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/chogo_meni_tyazhko_chogo_meni_nudno.html" class="linki2">Чого мені тяжко, чого мені нудно</a> <span class="text2">13 ноября 1844,
СПБ</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/chuma.html" class="linki2">Чума</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/shvachka.html" class="linki2">Швачка</a> <span class="text2">[Друга половина 1848,
                        Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yurodyvyi.html" class="linki2">Юродивий</a> <span class="text2">[Грудень 1857,
Нижній Новгород]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/ya_ne_zduzhayu-nivroku.html" class="linki2">Я не нездужаю, нівроку...</a> <span class="text2">1858, 22 ноября,
[С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yak_mayu_ya_zhurytysya.html" class="linki2">Як маю я журитися</a> <span class="text2">1858, 22 ноября,
                        [С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yak_by_vy_znaly_panychi.html" class="linki2">Якби ви знали, паничі...</a> <span class="text2">[Перша половина 1850.
Оренбург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yak_by_z_kym_sisty_zyisty_hliba.html" class="linki2">Якби з ким сісти хліба з`їсти...</a> <span class="text2">4 ноября [1860,
С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yak_by_zustrilysya_my_znovu.html" class="linki2">Якби зустрілися ми знову</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yakby_meni_cherevyki.html" class="linki2">Якби мені черевики</a> <span class="text2">[Друга половина 1848.
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yakby_meni_mamo_namysto.html" class="linki2">Якби мені, мамо, намисто</a> <span class="text2">[Друга половина 1848,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yakby_tobi_dovelosya.html" class="linki2">Якби тобі довелося ...</a> <span class="text2">[Перша половина 1849,
Косарал]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yakby_to_ty_bogdane_pyanyi.html" class="linki2">Якби-то ти, Богдане п`яний...</a> <span class="text2">[18 серпня 1859 в Переяславі]</span></td>
                    </tr>
                    <tr>
                      <th height="24" valign="top" class="linki2" scope="row">»</th>
                      <td valign="top"><a href="virshi/yakos_iduchi_unochi.html" class="linki2">Якось-то йдучи уночі ...</a> <span class="text2">13 ноября [1860,
    С.-Петербург]</span></td>
                    </tr>
                    <tr>
                      <th scope="row">&nbsp;</th>
                      <td>&nbsp;</td>
                    </tr>
                  </table>';

$doc = new DOMDocument();
$doc->encoding = 'UTF-8';
@$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

// extract tables
$xpath = new DOMXpath($doc);
$links = $xpath->query("//a");

$i = 1;

foreach ($links as $link) {
    echo '.';
    $title = cleanCyrillic($link->textContent);

    $url = 'http://taras-shevchenko.in.ua/' . $link->getAttribute('href');

    $html = file_get_contents($url);

    $doc = new DOMDocument();
    $doc->encoding = 'UTF-8';
    @$doc->loadHTML($html);

    $xpath = new DOMXpath($doc);
    $text = $xpath->query("//th[contains(@class, 'text')]");

    $content = $title . "\n\n" . $text[6]->textContent;

    file_put_contents('E:/DropBox/Dropbox/my/_Business/_WordsFromWords/php_dictionary_builder/Texts/TG/' . $i . '.txt', $content);
    $i++;
    sleep(1);
}



