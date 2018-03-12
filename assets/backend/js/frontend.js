// Opciones Generales para el DIV Grande
var option = '<div class="btn-group btn-options" id="btn-options" style="margin-top:-10px;margin-left:-28px;position:absolute;">';
option += '<span class="fa fa-arrow-up tooltips btn-up" id="btn-up" data-title="Subir" data-placement="left" style="font-size:11px;padding:5px;background:#f6f6f6;display:block;"></span>';
option += '<span class="fa fa-arrow-down tooltips btn-down" id="btn-down" data-title="Bajar" data-placement="left" style="font-size:11px;padding:5px;background:#f6f6f6;display:block;"></span>';
option += '<span class="fa fa-trash-o tooltips btn-delete" id="btn-delete" data-title="Eliminar" data-placement="left" style="font-size:11px;padding:5px;background:#f6f6f6;display:block;"></span>';
option += '<span class="fa fa-plus tooltips btn-new" id="btn-new" data-title="Nuevo" data-placement="left" style="font-size:11px;padding:5px;background:#f6f6f6;display:block;"></span>';
option += '</div>';
option += '</ul>';
option += '</div>';

function actualizar_orden() { nuevo_orden = $('.editable').length; }

// Elementos Editables..
function front_ready() 
{
	// Hover de Elementos..
	$('.editable').hover(
		function() {
			$(this).css({background:'#f6f6f6'});
			$(this).prepend(option);
		},
		function() {
			$(this).removeAttr('style');
			$(this).find('.btn-options').remove();
		}
	);

	$('.spinner').spinner({min: 0});

	$( ".sortable" ).sortable({

		// Actualización de Elementos..
		update: function(event, ui) {
			var elementos = $(this).children(); var count = elementos.length;

			if(count > 0)
			{
				var array = new Array((count - 1));

				$.each(elementos, function(i, item) {
					var id = $(item).children().attr('data-id'); var orden = $(item).children().attr('data-orden');

					if(i != orden)
					{
						$.ajax({
							url: backend_url+'dashboard/order_frontend',
							type: 'POST',
							dataType : 'json',
							data: { id: id, orden: i, token: xnToken },
							success: function(data) {
								imprimir(data);
							}
						});

						$(this).children().attr('data-orden', i);
					}
				});
			}
		}
		// Fin de la Actualización..
	});

	$( ".sortable-section" ).sortable({
		update: function(event, ui) {
			var elementos = $(this).children(); var count = elementos.length;

			if(count > 0)
			{
				var array = new Array((count - 1));

				$.each(elementos, function(i, item) {
					var id = $(item).attr('data-id'); var orden = $(item).attr('data-orden');

					if(i != orden)
					{
						$.ajax({
							url: backend_url+'dashboard/order_section_frontend',
							type: 'POST',
							dataType : 'json',
							data: { id: id, orden: i, token: xnToken },
							success: function(data) {
								imprimir(data);
							}
						});

						$(item).attr('data-orden', i);
					}
				});
			}
		}
		// Fin de la Actualización..
	});

	$('.editor').wysihtml5();
}


function remove_options(elemento)
{
	$(elemento).find('.btn-options').remove();
}

// Funciones Principales
$(document).on('click', '.btn-delete', function(e) { // Eliminar un Elemento
	var padre = $(this).parent().parent(); var id = padre.attr('data-id');
	// Eliminar el Elemento..

	jConfirm("¿Desea eliminar el Elemento?", "Eliminar un Elemento", function(a)
    {
        if (a == true)
        {
        	padre.parent().addClass('blur');

			$.ajax({
				url: backend_url+'dashboard/delete_frontend',
				type: 'POST',
				dataType: 'json',
				data: { token: xnToken, id: id },
				success: function(data) {
					imprimir(data);
					padre.remove();
				},
				error: function(data) {
					console.log("Falló al eliminar el registro..");
				}
			});
			return false;
		}
		else
		{
			return false;
		}
	});
});

// Actualización del Orden
$(document).on('click', '.btn-up', function(e) {
	e.preventDefault();
	var padre = $(this).parent().parent(); var id = padre.attr('data-id'); var orden = parseInt(padre.attr('data-orden'));

	console.log(orden+'Frente a '+nuevo_orden);

	if(orden == 0)
	{
		console.log("No se puede subir más !");
	}
	else
	{
		console.log("Se puede subir más !");
	}
});

$(document).on('click', '.btn-down', function(e) {
	e.preventDefault();
	var padre = $(this).parent().parent(); var id = padre.attr('data-id'); var orden = parseInt(padre.attr('data-orden')) + 1;

	console.log(orden+' Frente a '+nuevo_orden);

	if(orden < nuevo_orden)
	{
		console.log("Se puede bajar !");
	}
	else
	{
		console.log("No se puede bajar más !");
	}
});

$(document).on('click', '.btn-add', function(e) {
	var type = $(this).attr('data-type'); var texto = '';

	if(type == '1409782018') // Titulo
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '">' + show_title('') + '</div>';
	}
	if(type == '1409782035') // Texto
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '">' + show_textarea('') + '</div>';
	}
	if(type == '1409782082') // Image
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '">' + show_photo('') + '</div>';
	}
	if(type == '1409782072') // YouTube
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '" data-height="300" data-width="450">' + show_video_youtube('') + '</div>';
	}
	if(type == '1410050045') // Servicios
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '"><i>Listado de Servicios <strong>(No Modificable)</strong></i>' + show_buttons() + '</div>';
	}
	if(type == '1410050058') // Portafolio
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '"><i>Listado de Portafolio <strong>(No Modificable)</strong></i>' + show_buttons() + '</div>';
	}
	if(type == '1410050070') // Blog
	{
		texto += '<div class="editable" data-flag="editing" data-orden="' + nuevo_orden + '" data-type="' + type + '"><i>Listado de Noticias <strong>(No Modificable)</strong></i>' + show_buttons() + '</div>';
	}

	$('.clear').find('.sortable').append('<li class="item">' + texto + '</li>');
	front_ready();
});
// Fin de las Funciones Principales

// Títulos Editables..
$(document).on('click', '.editable-title', function(e) {
	e.preventDefault();
	var flag = $(this).attr('data-flag'); var id = $(this).attr('data-id'); var xnId = $(e.target).attr('id');

	if(xnId != 'btn-options' && xnId != 'btn-up' && xnId != 'btn-down' && xnId != 'btn-delete' && xnId != 'btn-new')
	{
		remove_options($(this)); var texto = $(this).html();
		var title = show_title(texto);
		$(this).html(title);
		$(this).attr('data-flag', 'editing');

		toggleClass($(this));
	}
});
// Fin del Título Editable..

// Textareas Editables..
$(document).on('click', '.editable-textarea', function(e) {
	e.preventDefault();
	var flag = $(this).attr('data-flag'); var id = $(this).attr('data-id'); var xnId = $(e.target).attr('id');

	if(xnId != 'btn-options' && xnId != 'btn-up' && xnId != 'btn-down' && xnId != 'btn-delete' && xnId != 'btn-new' && xnId != 'save_change' && xnId != 'reset_change')
	{
		remove_options($(this)); var texto = $(this).html(); texto = texto.replace('<br>', "\n");
		var textarea = show_textarea(texto);
		$(this).html(textarea);
		$(this).attr('data-flag', 'editing');
		front_ready();
	}

	toggleClass($(this));
});

$(document).on('click', '.editable-photo', function(e) {
	e.preventDefault();
	var flag = $(this).attr('data-flag'); var id = $(this).attr('data-id'); var xnId = $(e.target).attr('id');

	if(xnId != 'btn-options' && xnId != 'btn-up' && xnId != 'btn-down' && xnId != 'btn-delete' && xnId != 'btn-new')
	{
		remove_options($(this)); var texto = $(this).find('img').attr('src'); texto = texto.replace(base_url + 'uploads/', "");
		var textarea = show_photo(texto);
		$(this).html(textarea);
		$(this).attr('data-flag', 'editing');
		front_ready();

		toggleClass($(this));
	}
});

$(document).on('click', '.editable-video-youtube', function(e) {
	e.preventDefault();
	var flag = $(this).attr('data-flag'); var id = $(this).attr('data-id'); var xnId = $(e.target).attr('id');

	if(xnId != 'btn-options' && xnId != 'btn-up' && xnId != 'btn-down' && xnId != 'btn-delete' && xnId != 'btn-new')
	{
		remove_options($(this)); var texto = $(this).find('iframe').attr('src'); texto = texto.split('/embed/');
		var video_youtube = show_video_youtube('http://www.youtube.com/watch?v=' + texto[1], $(this).attr('data-height'), $(this).attr('data-width'));
		$(this).html(video_youtube);
		$(this).attr('data-flag', 'editing');
		front_ready();

		toggleClass($(this));
	}
});

$(document).on('click', '.save_change', function(e) {
	e.preventDefault();

	// Funciones para el guardado de información..
	change($(this), 'true');
});

$(document).on('click', '.reset_change', function(e) {
	e.preventDefault();
	change($(this));
});

function change(elemento, post)
{
	var padre = $(elemento).parent().parent().parent(); var type = padre.attr('data-type'); var contenido = ''; var id = padre.attr('data-id'); var flag = '';

	if(type == '1409782018') // Pertence a un Título..
	{
		contenido = padre.find('input').val();
		if(contenido != '')
		{
			padre.html(contenido); padre.addClass('editable-title');
		}
	}
	if(type == '1409782035') // Pertecene a un Textarea..
	{
		contenido = padre.find('textarea').val();
		if(contenido != '')
		{
			contenido = contenido.replace(/\n/g, '<br>');
			padre.html(contenido); padre.addClass('editable-textarea');
		}
	}
	if(type == '1409782082') // Pertenece a una Imagen..
	{
		contenido = padre.parent().find('#name_photo').val();
		if(contenido != '')
		{
			padre.html('<img src="' + base_url + 'uploads/' + contenido + '" />'); padre.addClass('editable-photo');
		}
	}
	if(type == '1409782072') // Pertenece a un Video de YouTube
	{
		contenido = padre.find('input').val(); var height = padre.find('.height').val(); var width = padre.find('.width').val();
		if(contenido != '')
		{
			contenido = contenido.split("v=");
			padre.html('<iframe src="http://www.youtube.com/embed/'+contenido[1]+'" style="border:none;height:' + height + 'px;width:' + width + 'px;"></iframe>');
			padre.addClass('editable-video-youtube'); padre.attr('data-height', height); padre.attr('data-width', width);
			contenido = contenido[1]; flag = 'height:'+height+'|'+'width:'+width;
		}
	}
	if(type == '1410050045') // Pertence a un Servicio..
	{
		contenido = padre.find('i').html();
		if(contenido != '')
		{
			padre.html('<i>'+contenido+'</i>'); padre.addClass('editable-services');
		}
	}
	if(type == '1410050058') // Pertence a un Portafolio..
	{
		contenido = padre.find('i').html();
		if(contenido != '')
		{
			padre.html('<i>'+contenido+'</i>'); padre.addClass('editable-services');
		}
	}
	if(type == '1410050070') // Pertence a un Blog..
	{
		contenido = padre.find('i').html();
		if(contenido != '')
		{
			padre.html('<i>'+contenido+'</i>'); padre.addClass('editable-services');
		}
	}

	if(post === 'true')
	{
		padre.parent().addClass('blur');

		if(id != undefined) // Actualizar Datos
		{
			// Datos que se enviarán por JQuery - Ajax !
			$.ajax({
				url: backend_url+'dashboard/update_frontend',
				type: 'POST',
				dataType: 'json',
				data: { token: xnToken, id: id, contenido: contenido, type: type, flag: flag },
				success: function(data) {
					imprimir(data);
					setTimeout(function() { padre.removeAttr('data-flag'); padre.removeAttr('style'); padre.parent().removeClass('blur'); }, 50);
				},
				error: function(data) {
					console.log("Hubo un Error al actualizar el registro..");
				}
			});
		}
		else // Agregar nuevo Registro..
		{
			$.ajax({
				url: backend_url+'dashboard/add_frontend',
				type: 'POST',
				dataType: 'json',
				data: { token: xnToken, contenido: contenido, type: type, orden: nuevo_orden, id_seccion: id_seccion, flag: flag },
				success: function(data) {
					// Aumentando la cantidad de elementos.. Al guardar un nuevo elemento !
					nuevo_orden++;

					padre.attr('data-id', data['id']);
					imprimir(data);
					setTimeout(function() { padre.removeAttr('data-flag'); padre.removeAttr('style'); padre.parent().removeClass('blur'); }, 50);
				},
				error: function(data) {
					console.log("Hubo un Error al agregar el registro..");
				}
			});
		}
	}
	else // Se cancela la operación..
	{
		if(id != undefined)
		{
			// Remover el Flag que nos permitirá editar nuevamente.. y quitarle los estilos..
			setTimeout(function() { padre.removeAttr('data-flag'); padre.removeAttr('style'); }, 50);
		}
		else
		{
			padre.remove();
		}
	}
	
}


function show_title(value)
{
	var texto = '';
	texto += '<input type="text" class="form-control col-sm-12" data-flag="editing" value="' + value + '" style="float:none;" />';
	texto += show_buttons();
	
	return texto;
}

function show_textarea(value)
{
	var texto = '';
	texto += '<textarea class="editor col-md-12" rows="9" data-flag="editing" style="float:none;">';
	texto += value;
	texto += '</textarea>';
	texto += show_buttons();

	return texto;
}

function show_video_youtube(value, height, width)
{
	var texto = '';
	texto += '<input type="text" class="form-control col-sm-12" data-flag="editing" value="' + value + '" style="float:none;" /><br />';
	texto += '<label class="col-sm-3" style="margin-top:7px;">Height: </label>';
	texto += '<div class="spinner col-sm-3">';
	texto += '<div class="input-group">';
	texto += '<div class="spinner-buttons input-group-btn">';
	texto += '<button type="button" class="btn spinner-up btn-primary">';
	texto += '<i class="fa fa-plus"></i>';
	texto += '</button>';
	texto += '</div>';
	texto += '<input type="text" class="spinner-input form-control col-sm-3 height" value="' + height + '" />';
	texto += '<div class="spinner-buttons input-group-btn">';
	texto += '<button type="button" class="btn spinner-down btn-warning">';
	texto += '<i class="fa fa-minus"></i>';
	texto += '</button>';
	texto += '</div>';
	texto += '</div>';
	texto += '</div>';
	texto += '<label class="col-sm-3" style="margin-top:7px;">Width: </label>';
	texto += '<div class="spinner col-sm-3">';
	texto += '<div class="input-group">';
	texto += '<div class="spinner-buttons input-group-btn">';
	texto += '<button type="button" class="btn spinner-up btn-primary">';
	texto += '<i class="fa fa-plus"></i>';
	texto += '</button>';
	texto += '</div>';
	texto += '<input type="text" class="spinner-input form-control col-sm-3 width" value="' + width + '" />';
	texto += '<div class="spinner-buttons input-group-btn">';
	texto += '<button type="button" class="btn spinner-down btn-warning">';
	texto += '<i class="fa fa-minus"></i>';
	texto += '</button>';
	texto += '</div>';
	texto += '</div>';
	texto += '</div>';
	texto += show_buttons();
	
	return texto;
}

function show_photo(value)
{
	var texto = '<form id="upload_photo" action="'+backend_url+'dashboard/upload_photo_frontend" method="POST" target="oculto" enctype="multipart/form-data">';
	texto += '<input type="hidden" name="name_photo" id="name_photo" value="' + value + '" />';
	texto += '<div>';
	texto += '<div class="fileupload fileupload-new" data-provides="fileupload">';
	texto += '<div class="fileupload-new thumbnail" style="width: 200px; height: 200px;">';
	if(value != '')
	{
		texto += '<img src="' + base_url + 'uploads/' + value + '" alt="">';
	}
	else
	{
		texto += '<img src="http://www.placehold.it/200x200/EFEFEF/AAAAAA&amp;text=Imagen" alt="">';
	}
	texto += '</div>';
	texto += '<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>';
	texto += '<div>';
	texto += '<span class="btn btn-white btn-file">';
	texto += '<span class="fileupload-new"><i class="fa fa-paper-clip"></i> Seleccionar Imagen</span>';
	texto += '<span class="fileupload-exists"><i class="fa fa-undo"></i> Cambiar Imagen</span>';
	texto += '<input type="file" name="photo" id="photo" class="default" onchange="javascript:upload_photo(this);">';
	texto += '</span>';
	texto += '</div>';
	texto += '</div>';
	texto += '<span class="label label-danger">Importante!</span>';
	texto += '<span>';
	texto += ' Para el correcto funcionamiento se necesitará una versión de Navegador actualizada.';
	texto += '</span>';
	texto += '</div>';
	texto += '</form>';

	texto += show_buttons();

	return texto;
}

function show_buttons()
{
	var buttons = '';
	buttons += '<div class="form-group">';
	buttons += '<div class="col-sm-12 row" style="margin-top:10px;">';
	buttons += '<button type="button" class="btn btn-primary btn-sm save_change">Guardar</button> <button type="button" class="btn btn-danger btn-sm reset_change">Cancelar</button>';
	buttons += '</div>';
	buttons += '</div>';

	return buttons;
}

function toggleClass(elemento)
{
	$(elemento).removeAttr('class').addClass('editable');
}

function upload_photo(elemento)
{
	$('#upload_photo').submit();
}

function return_name_photo(imagen)
{
	$('#name_photo').val(imagen); $('#name_photo').attr('value', imagen);
	//imprimir(data);
}

$(document).ready(function(e) {
	front_ready();
});
