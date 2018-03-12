<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Simple_image {

	var $image = FALSE;
	var $type = FALSE;
	var $width = FALSE;
	var $height = FALSE;
	var $source = FALSE;
	var $flag = FALSE;
	var $folder = FALSE;
	var $sizes = array();
	var $filename = FALSE;

	public function __construct($props = array())
	{
		if (count($props) > 0)
		{
			$this->initialize($props);
		}

		log_message('debug', "Image Lib Class Initialized");
	}

	function initialize($props = array())
	{
		foreach($props as $key => $value)
		{
			$this->$key = $value;
		}

		$this->loadImage($this->source); // Cargar la imagen al instante de instalar el archivo
	}

	function clear()
	{
		$this->filename = FALSE;
		$this->image = FALSE;
		$this->type = FALSE;
		$this->width = FALSE;
		$this->height = FALSE;
		$this->source = FALSE;
		$this->flag = FALSE;
		$this->folder = FALSE;
		$this->sizes = array();
	}

	//---Método de leer la imagen
	function loadImage($name)
	{
		//---Tomar las dimensiones de la imagen
		$info = getimagesize($name);

		$this->width = $info[0];
		$this->height = $info[1];
		$this->type = $info[2];

		//---Dependiendo del tipo de imagen crear una nueva imagen
		switch($this->type)
		{
			case IMAGETYPE_JPEG:
			$this->image = imagecreatefromjpeg($name);
			break;
			case IMAGETYPE_GIF:
			$this->image = imagecreatefromgif($name);
			break;
			case IMAGETYPE_PNG:
			$this->image = imagecreatefrompng($name);
			break;
		}
	}

	//---Método de guardar la imagen
	function save($quality = 100)
	{
		$name = $this->folder.$this->filename; // Folder donde se guardará la imagen
		//---Guardar la imagen en el tipo de archivo correcto
		switch($this->type)
		{
			case IMAGETYPE_JPEG:
			imagejpeg($this->image, $name, $quality);
			break;
			case IMAGETYPE_GIF:
			imagegif($this->image, $name);
			break;
			case IMAGETYPE_PNG:
			$pngquality = floor(($quality - 10) / 10);
			imagepng($this->image, $name, $pngquality);
			break;
		}
	}

	//---Método de mostrar la imagen sin salvarla
	function show() {

	//---Mostrar la imagen dependiendo del tipo de archivo
	switch($this->type){
	case IMAGETYPE_JPEG:
	imagejpeg($this->image);
	break;
	case IMAGETYPE_GIF:
	imagegif($this->image);
	break;
	case IMAGETYPE_PNG:
	imagepng($this->image);
	break;
	}
	}

	//---Método de redimensionar la imagen sin deformarla
	function resize()
	{
		$img_width = imagesx($this->image); //Get image width
		$img_height = imagesy($this->image); //Get image height

		$scale = max($this->size['width']/$img_width, $this->size['height']/$img_height); 
		$new_width = floor($scale*$img_width); //Obtiene el nuevo tamaño al resize calculado
		$new_height = floor($scale*$img_height); //Obtiene el nuevo tamaño al resize calculado

		$new_img = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new_img, $this->image, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height);

		//Ahora le sacamos una sub-imagen de exactos pixels
		$new_x = floor(($new_width - $this->size['width']) / 2);
		$new_y = floor(($new_height - $this->size['height']) / 2);
           
		$res = imagecreatetruecolor ($this->size['width'], $this->size['height']);
		$blanco=imagecolorallocate ($res, 255, 255, 255);
		imagefill ($res, 1, 1, $blanco);

		imagecopy($res, $new_img, 0, 0, $new_x, $new_y, $this->size['width'], $this->size['height']);

		//Genera fisicamente la imagen procesada antes
		imagejpeg($res, $this->folder.$this->filename); //Output image to browser or file

		imagedestroy($new_img); //Destroy an image (liberando memoria)
		imagedestroy($res); //Destroy an image (liberando memoria)

		/*
		//---Hacer una copia de la imagen dependiendo de la propiedad a variar
		switch($this->flag)
		{

			case 'width':
			imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value, $value_versus, $this->width, $this->height);
			break;

			case 'height':
			imagecopyresampled($image, $this->image, 0, 0, 0, 0, $value_versus, $value, $this->width, $this->height);
			break;
		}

		$this->width = imagesx($image);
		$this->height = imagesy($image);
		$this->image = $image;
		*/
	}

	//---Método de extraer una sección de la imagen sin deformarla
	function crop($cwidth, $cheight, $pos = 'center') {

	//---Dependiendo del tamaño deseado redimensionar primero la imagen a uno de los valores
	if($cwidth > $cheight){
	$this->resize($cwidth, 'width');
	}else{
	$this->resize($cheight, 'height');
	}

	//---Crear la imagen tomando la porción del centro de la imagen redimensionada con las dimensiones deseadas
	$image = imagecreatetruecolor($cwidth, $cheight);

	switch($pos){

	case 'center':
	imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
	break;

	case 'left':
	imagecopyresampled($image, $this->image, 0, 0, 0, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
	break;

	case 'right':
	imagecopyresampled($image, $this->image, 0, 0, $this->width - $cwidth, abs(($this->height - $cheight) / 2), $cwidth, $cheight, $cwidth, $cheight);
	break;

	case 'top':
	imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), 0, $cwidth, $cheight, $cwidth, $cheight);
	break;

	case 'bottom':
	imagecopyresampled($image, $this->image, 0, 0, abs(($this->width - $cwidth) / 2), $this->height - $cheight, $cwidth, $cheight, $cwidth, $cheight);
	break;

	}

	$this->image = $image;
	}

}

/* End of file MY_Image_lib.php */
/* Location: ./application/libraries/MY_Image_lib.php */