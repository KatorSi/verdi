<?php /** @var array $data */?>
<div class="content-header">
    <div class="content-header-top-menu">
        <ul>
            <li class="active"><a href="<?= \Config::$host . 'home/index' ?>">Композиторы</a></li>
            <li><a href="<?= \Config::$host . 'home/poster' ?>">Афиша</a></li>
            <li>
                <span class="title title-big">Музыкальный портал</span>
            </li>
            <li>Полотно времени</li>
            <li>Справочники</li>
        </ul>
    </div>
</div>
<div class="content-body">
    <div id="target">
        <table class="table table-default main-table">
            <thead>
            <tr>
                <td class="year birthday-year" data-sort="asc">Год рожд.</td>
                <td class="year deathday-year">Год смерти</td>
                <td style="width: 215px;">Композиторы</td>
                <td style="width: 120px;">Страна <select name="country" id="country" class="select_custom">
                        <option value="all">Все</option>
                        <?php foreach ($data['countries'] as $country) : ?>
                            <option value="<?= $country['id'] ?>"><?= $country['title'] ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td style="width: 180px;">Город рождения</td>
                <td style="width: 180px;">Муз. стиль <select name="genre" id="genre" class="select_custom">
                        <option value="all">Все</option>
                        <?php foreach ($data['genres'] as $genre) : ?>
                            <option value="<?= $genre['id'] ?>"><?= $genre['title'] ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td data-sorter="none">Основные направления</td>
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
                    <a class="composers_link" style="font-weight: bold;" href="<?= \Config::$host . 'composer/' . $data['verdi']['id'] ?>"><?= $data['verdi']['title']; ?></a>
                </td>
                <td style="width: 120px;"><?= $data['verdi']['country']; ?></td>
                <td style="width: 180px;"><?php echo $data['verdi']['city']; ?></td>
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
                <td style="width: 180px;"><?= $data['mozart']['genre']; ?></td>
                <td><?php echo $data['mozart']['sector']; ?></td>
            </tr> */ ?>
            <?php if (!empty($data['composers'])) :
                foreach ($data['composers'] as $composer) : ?>
                    <tr class="inFilter sort" data-country="<?= $composer['country_id'] ?>"
                            data-genre="<?= $composer['genre_id'] ?>" data-composer="<?= $composer['id'] ?>">
                        <td class="year"><?php echo intval($composer['birthYear']) > 0 ? $composer['birthYear'] : ''; ?></td>
                        <td class="year"><?php echo intval($composer['deathYear']) > 0 ? $composer['deathYear'] : ''; ?></td>
                        <td style="width: 215px;">
                            <a class="composers_link" <?php echo in_array($composer['id'], [132, 39]) ? 'style="font-weight: bold;"' : ''; ?> href="<?= \Config::$host . 'composer/' . $composer['id'] ?>"><?= $composer['title']; ?></a>
                        </td>
                        <td style="width: 120px;"><?= $composer['country']; ?></td>
                        <td style="width: 180px;"><?php echo $composer['city']; ?></td>
                        <td style="width: 180px;"><?= $composer['genre']; ?></td>
                        <td><?php echo $composer['sector']; ?></td>
                    </tr>
                <?php endforeach;
            endif; ?>
            </tbody>
        </table>
    </div>
</div>

