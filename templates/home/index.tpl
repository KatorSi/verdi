<?php /** @var array $data */?>
<div class="content-header">
    <div class="content-header-top-menu">
        <div class="row">
            <!--<div class="col-lg-1 col-lg-offset-3 menu-item">
                <a href="<?= \Config::$host . 'poster' ?>">Афиша</a>
            </div>-->
            <div class="col-lg-12 menu-title">
                <span class="title title-big">Музыкальный портал</span>
            </div>
            <!--<div class="col-lg-2 menu-item">
                <a class="active" href="<?= \Config::$host?>">Композиторы</a>
            </div>-->
            <!--<div class="col-lg-2 menu-item">
                <a class="no_active" href="https://v1battle.ru/" target="_blank">Баттлы V1</a>
            </div>-->
        </div>
    </div>
</div>
<div class="content-body">
    <div id="target">
        <table class="table table-default main-table">
            <thead>
            <tr>
                <td rowspan="2" class="year birthday-year vert-align-middle" data-sort="asc">Год рожд.</td>
                <td rowspan="2" class="year deathday-year vert-align-middle">Год смерти</td>
                <td rowspan="2" class="vert-align-middle" style="width: 215px;">Композиторы</td>
                <td rowspan="2" class="vert-align-middle" style="width: 120px;">Страна <select name="country" id="country" class="select_custom">
                        <option value="all">Все</option>
                        <?php foreach ($data['countries'] as $country) : ?>
                            <option value="<?= $country['id'] ?>"><?= $country['title'] ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td rowspan="2" class="vert-align-middle" style="width: 150px;">Город рождения</td>
                <td rowspan="2" class="vert-align-middle" style="width: 150px;">Муз. стиль <select name="genre" id="genre" class="select_custom">
                        <option value="all">Все</option>
                        <?php foreach ($data['genres'] as $genre) : ?>
                            <option value="<?= $genre['id'] ?>"><?= $genre['title'] ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td colspan="7" data-sorter="none">Основные направления</td>
                    <tr class="composers_work">
                    <td>опера</td>
                    <td>симф</td>
                    <td>конц</td>
                    <td>соната</td>
                    <td>дух</td>
                    <td>инстр</td>
                    <td>вокал</td>
                    </tr>
            </tr>
            </thead>
        </table>
    </div>
    <div class="table-fixer">
        <table class="table table-default table-data">
            <tbody>
            <?php /* <tr class="inFilter" data-country="<?= $data['verdi']['country_id'] ?>"
                    data-genre="<?= $data['verdi']['genre_id'] ?>" data-composer="<?= $data['verdi']['id'] ?>">
                <td class="year"><?php echo intval($data['verdi']['birthYear']) > 0 ? $data['verdi']['birthYear'] : ''; ?></td>
                <td class="year"><?php echo intval($data['verdi']['deathYear']) > 0 ? $data['verdi']['deathYear'] : ''; ?></td>
                <td style="width: 215px;">
                    <a class="composers_link" style="font-weight: bold;" href="<?= \Config::$host.'composer/'.$data['verdi']['id'] ?>"><?= $data['verdi']['title']; ?></a>
                </td>
                <td style="width: 120px;"><?= $data['verdi']['country']; ?></td>
                <td style="width: 150px;"><?php echo $data['verdi']['city']; ?></td>
                <td style="width: 180px;"><?= $data['verdi']['genre']; ?></td>
                <td><?php echo $data['verdi']['sector']; ?></td>
            </tr>
            <tr class="inFilter" data-country="<?= $data['mozart']['country_id'] ?>"
                    data-genre="<?= $data['mozart']['genre_id'] ?>" data-composer="<?= $data['mozart']['id'] ?>">
                <td class="year"><?php echo intval($data['mozart']['birthYear']) > 0 ? $data['mozart']['birthYear'] : ''; ?></td>
                <td class="year"><?php echo intval($data['mozart']['deathYear']) > 0 ? $data['mozart']['deathYear'] : ''; ?></td>
                <td style="width: 215px;">
                    <a class="composers_link" style="font-weight: bold;" href="<?= \Config::$host . 'composer/' . $data['mozart']['id'] ?>"><?= $data['mozart']['title']; ?></a>
                </td>
                <td style="width: 120px;"><?= $data['mozart']['country']; ?></td>
                <td style="width: 180px;"><?php echo $data['mozart']['city']; ?></td>
                <td style="width: 150px;"><?= $data['mozart']['genre']; ?></td>
                <td><?php echo $data['mozart']['sector']; ?></td>
            </tr> */ ?>
            <?php if (!empty($data['composers'])) :
                foreach ($data['composers'] as $composer) : ?>
                    <tr class="inFilter sort" data-country="<?= $composer['country_id'] ?>"
                            data-genre="<?= $composer['genre_id'] ?>" data-composer="<?= $composer['id'] ?>">
                        <td class="year"><?php echo intval($composer['birthYear']) > 0 ? $composer['birthYear'] : ''; ?></td>
                        <td class="year"><?php echo intval($composer['deathYear']) > 0 ? $composer['deathYear'] : ''; ?></td>
                        <td style="width: 215px;">
                            <a class="composers_link" <?php echo in_array($composer['id'], [132, 39]) ? 'style="font-weight: bold;"' : ''; ?> href="<?= !empty($composer['opera']) ? \Config::$host.'composer/'.$composer['id'].'/operas' : \Config::$host.'composer/'.$composer['id'] ?>"><?= $composer['title']; ?></a>
                        </td>
                        <td style="width: 120px;"><?= $composer['country']; ?></td>
                        <td style="width: 150px;"><?php echo $composer['city']; ?></td>
                        <td style="width: 150px;"><?= $composer['genre']; ?></td>
                        <td class="text-right"><?= ($composer['opera'] == true) ? $composer['opera'] : ''; ?></td>
                        <td class="text-right"><?= ($composer['symphony'] == true) ? $composer['symphony'] : ''; ?></td>
                        <td class="text-right"><?= ($composer['concert'] == true) ? $composer['concert'] : ''; ?></td>
                        <td class="text-right"><?= ($composer['sonata'] == true) ? ✓ : ''; ?></td>
                        <td class="text-center"><?= ($composer['brass'] == true) ? ✓ : ''; ?></td>
                        <td class="text-center"><?= ($composer['instrumental'] == true) ? ✓ : ''; ?></td>
                        <td class="text-center"><?= ($composer['vocal'] == true) ? ✓ : ''; ?></td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
</div>

