<?php
/**
 * Created by PhpStorm.
 * User: iis
 * Date: 22.11.2018
 * Time: 15:52
 */

namespace Controller;


use Helpers\Blueimp\CustomUploader;

class Files
{

    public $uploadFolder = 'uploads';


    /**
     * Получить файл по id
     *
     * @param int $id
     *
     * @return array|false
     */
    public static function getFileById($id)
    {
        Main::$pdo->query("SELECT * FROM `files` WHERE `id`=:id");
        Main::$pdo->bind(':id', intval($id));

        return Main::$pdo->single();
    }

    /**
     * Получить список файлов для объекта
     *
     * @param string $owner
     * @param int $ownerId
     * @param string $type
     *
     * @return array|false
     */
    public static function getFilesByOwnerId($owner, $ownerId, $type = '')
    {
        Main::$pdo->query("SELECT * FROM `files` WHERE `owner`=:owner AND `owner_id`=:ownerId AND `type`=:type order by title");
        Main::$pdo->bind(':owner', $owner);
        Main::$pdo->bind(':ownerId', intval($ownerId));
        Main::$pdo->bind(':type', $type);

        return Main::$pdo->resultset();
    }


    /**
     * Запись файла в бд
     *
     * @param array $file
     *
     * @return array|false
     */
    public function save($file)
    {
        $file = $this->valid($file);
        $result = Main::$pdo->insert($file, 'files');

        if (true === $result['status']) {
            $file['id'] = $result['message'];
            return $file;
        }

        return false;
    }


    /**
     * @param $file
     *
     * @return array|false
     */
    public function update($file)
    {
        $file = $this->valid($file);
        $id = intval($file['id']);

        $result = Main::$pdo->update($file, ['id' => $id], 'files');

        if (true === $result['status']) {
            return $file;
        }

        return false;
    }


    /**
     * @param string $type
     * @param string $owner
     * @param int $ownerId
     *
     * @return array|false
     */
    public function upload($type, $owner, $ownerId)
    {
        $filePath = "/{$this->uploadFolder}/{$owner}/{$type}/{$ownerId}/";


        $upload = new CustomUploader([
            'upload_dir' => \Config::$basePath . $filePath,
            'param_name' => $type
        ], false);
        $upload_results = $upload->post(false);
        if (!empty($upload_results[$type]) && !isset($upload_results[$type][0]->error)/* && $upload_results[$type][0]->size == $_GET['s']*/) {
            $fileInfo = $this->getFileInfo($upload_results[$type][0]->originalName);

            $fileData = [
                'path'     => $filePath,
                'name'     => $upload_results[$type][0]->name,
                'title'    => $fileInfo[0],
                'type'     => $type,
                'owner'    => $owner,
                'owner_id' => $ownerId,
                'size'     => $upload_results[$type][0]->size,
            ];

            $fileData = $this->save($fileData);
            $fileData['res'] = $upload_results[$type];
            return $fileData;
        }
        return false;
    }


    /**
     * Валидация полей для записи в бд
     *
     * @param $file
     *
     * @return array
     */
    private function valid($file)
    {
        if (isset($file['id'])) {
            $file['id'] = intval($file['id']);
        }

        $file['owner'] = isset($file['owner']) ? $file['owner'] : '';
        $file['owner_id'] = isset($file['owner_id']) ? intval($file['owner_id']) : 0;
        $file['size'] = isset($file['size']) ? intval($file['size']) : 0;
        $file['name'] = isset($file['name']) ? $file['name'] : '';
        $file['path'] = isset($file['path']) ? $file['path'] : '';
        $file['type'] = isset($file['type']) ? $file['type'] : '';

        return $file;
    }


    /**
     * @param string $file
     *
     * @return array [ 0 => filename, 1 => extension, 2 => path]
     */
    private function getFileInfo($file)
    {
        $filePaths = explode('/', $file);

        $fileFullName = array_pop($filePaths);

        $fileNames = explode('.', $fileFullName);
        $ext = array_pop($fileNames);
        $origFileName = implode('.', $fileNames);
        $response = [
            $origFileName,
            $ext,
            implode('/', $filePaths)
        ];
        return $response;
    }

    public static function remove($id)
    {
        $response = Main::$pdo->delete('files', ['id' => intval($id)]);
        return $response['status'] == true;
    }


    /**
     * удаляет файл
     *
     * @param String $path путь к файлу
     *
     * @return bool
     */
    public static function removeFile($path)
    {
        if (file_exists($path) && is_file($path)) {
            return unlink($path);
        }

        return false;
    }

}