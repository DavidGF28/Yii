<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string|null $nombre
 * @property string|null $foto
 * @property int|null $almacen
 * @property string|null $fecha
 *
 * @property Almacenes $almacen0
 */
class Productos extends \yii\db\ActiveRecord
{
    public $actualizar;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['almacen'], 'integer'],
            [['fecha'], 'safe'],
            [['nombre'], 'string', 'max'=>255],
            [['foto'], 'file', 'skipOnEmpty'=>true, 'extensions'=>'png,jpg'],
            [['almacen'], 'exist', 'skipOnError' => true, 'targetClass' => Almacenes::className(), 'targetAttribute' => ['almacen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'foto' => 'Foto',
            'almacen' => 'Almacen',
            'fecha' => 'Fecha',
        ];
    }

    /**
     * Gets query for [[Almacen0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlmacen0()
    {
        return $this->hasOne(Almacenes::className(), ['id' => 'almacen']);
    }
    public function afterFind() {
        parent::afterFind();
        $this->fecha=Yii::$app->formatter->asDate($this->fecha, 'php:d/m/Y');
    }
    
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        $this->fecha= \DateTime::createFromFormat("d/m/Y", $this->fecha)->format("Y/m/d");
        $this->actualizar=true;
        if(!isset($this->foto)){
            $this->foto=$this->getOldAttribute("foto");
            $this->actualizar=false;
        }
        return true;
    }
    
    public function afterSave($insert, $changedAttributes) {
       if($this->actualizar){
           $this->foto->SaveAs('imgs/'.$this->id . iconv('UTF-8','ISO-8859-1', $this->foto->name),false);
           $this->foto=$this->id . iconv('UTF-8','ISO-8859-1', $this->foto->name);
       }
       $this->updateAttributes(["foto"]);
    }
    
    public function getFoto(){
        return Yii::$app->request->getBaseUrl().'/imgs/'.$this->foto;
    }
}
