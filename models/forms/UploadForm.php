<?php

namespace app\models\forms;

use app\components\Picture;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imagePath;

    const TYPE_PAGES = 'pages';
    const TYPE_NEWS = 'news';
    const TYPE_RESULTS = 'results';
    const TYPE_EMAILS = 'emails';
    const TYPE_GALLERY = 'gallery';
    const TYPE_REVIEWS = 'reviews';

    const UPLOAD_DIR = 'web/images';
    const VIEW_DIR = 'images';

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    public function upload($type = self::TYPE_PAGES)
    {
        if ($this->validate()) {
            $ext = $this->imageFile->extension;

            $name = uniqid($type . '_') . '.' . $ext;
            $path = \Yii::$app->basePath . '/' . self::UPLOAD_DIR . '/' . $type;
            $result_path = $path . '/' . $name;

            if ($type == self::TYPE_GALLERY) {

                $path_img_mini = str_replace('.' . $ext, '_min.' . $ext, $result_path);

                // миниатюры для галереи
                $this->imageFile->saveAs($result_path . 'original');

                $this->resize($result_path . 'original', $result_path, 1200, 2000);
                $this->resize($result_path . 'original', $path_img_mini, 400, 300);

                // удаляем
                unlink($result_path . 'original');

            } elseif ($type == self::TYPE_REVIEWS) {

                $path_img_mini = str_replace('.' . $ext, '_min.' . $ext, $result_path);
                $path_img_maxi = str_replace('.' . $ext, '_max.' . $ext, $result_path);

                // миниатюры для галереи
                $this->imageFile->saveAs($result_path . 'original');

                $this->resize($result_path . 'original', $path_img_maxi, 1200, 1200);
                $this->resize($result_path . 'original', $result_path, 200, 200);
                $this->resize($result_path . 'original', $path_img_mini, 50, 50);

                // удаляем
                unlink($result_path . 'original');

            } else {
                
                $this->imageFile->saveAs($result_path);
    
                $m200 = str_replace('.' . $ext, '_m200.' . $ext, $result_path);
                $m400 = str_replace('.' . $ext, '_m400.' . $ext, $result_path);
                
                usleep(250000);
    
                // миниатюры
                $this->resize($result_path, $m200, 200, 200);
                $this->resize($result_path, $m400, 400, 400);
            }

            $this->imagePath = '/' . self::VIEW_DIR . '/' . $type . '/' . $name;
            return true;
        } else {
            return false;
        }
    }

    public function getImagePath($full_path = false, $small = false) {

        $img_path = $this->imagePath;

        if ($small) {
            $img_path = str_replace('.', '_min.', $img_path);
        }

        if ($full_path) {
            $img_path = Yii::$app->request->hostInfo . $img_path;
        }

        return $img_path;
    }

    public static function getSrc($img_name, $type = self::TYPE_PAGES, $suffix = '') {

        $src = [self::VIEW_DIR];
        $src[] = $type;
        $src[] = str_replace('.jpg', "{$suffix}.jpg", $img_name);

       return '/' . implode('/', $src);
    }

    function resize($img_source, $img_dest, $w, $h) {

        $new_image = new Picture($img_source);
        $new_image->autoimageresize($w, $h);
        $new_image->imagesave($new_image->image_type, $img_dest);
        $new_image->imageout();

        $water_path = Yii::getAlias('@app') . '/web/img/watermark.png';
        $water = new Picture($img_dest);
        $water->watermark($water_path, 10, 10);
        $water->imageout();
    }
}