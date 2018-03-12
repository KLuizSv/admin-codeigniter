var parent = $('#content-main');
var xnReadonly = 0;

$.blockUI({
    overlayCSS: { backgroundColor: '#000', cursor: 'wait', zIndex: '1001' },
    message: '<p style="margin:10px;padding:0px;">Espere un momento <img src="' + backend_view + 'loading.gif" /></p>'
});

$(window).load(function() {
    $.unblockUI();
});

$(window).load(function() {
    $('#main-content').css('display', 'block');
});

document.oncontextmenu = function() { return false; }

$(document).ajaxStart(function() {
    $.blockUI({
        overlayCSS: { backgroundColor: 'transparent', cursor: 'wait', zIndex: '1001' },
        message: ''
    });
});

$(document).on('submit', 'form', function() {
    $('#parent').attr('value', url_parent);
    $('#parent').val(url_parent);

    $.blockUI({
        overlayCSS: { backgroundColor: '#000', cursor: 'wait', zIndex: '1001' },
        message: '<p style="margin:10px;padding:0px;">Procesando solicitud. Espere un momento <img src="' + backend_view + 'loading.gif" /></p>'
    });
});

$(document).ajaxStop(function() {
    $.unblockUI();
});

var div_message = '<div class="alert message" style="display:none"></div>';

function remover(xnElemento, xnTable, xnItem, xnId)
{
    // Función para eliminar la imagen..
    $.ajax({
        url: backend_url+'dashboard/remover',
        type: 'POST',
        dataType: 'json',
        data: { token : xnToken, parent : url_parent, key: xnItem, table: xnTable, id: xnId },
        success: function(data) {
            if(data != '' && data != null)
            {
                imprimir(data); // Imprimiendo Resultados..
                
                // Eliminando vistas previas..
                $(xnElemento).remove();
                $(xnElemento).parent().parent().find('.fileupload-new').css({ 'display': 'none' });
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error..");
        }
    });
    return false;
}

function importar_registros(elemento)
{
    $(elemento).parents('form').submit(); $.blockUI();
}

function exportar_registros(elemento)
{
    $(elemento).parents('form').submit(); $.unblockUI();
}

function imprimir(data)
{
    $.unblockUI();

    /*
    $(div_message).addClass(data['type']);
    $(div_message).html(data['mensaje']);
    $('#message').html(div_message);

    setTimeout(function(){ $('#message').slideToggle(); }, 100);
    */

    if(data['mensaje'] != undefined)
    {
        $.gritter.add({
            title: '',
            text: data['mensaje']
        });
    }

    if(data['url'] != undefined && data['url'] != null)
    {
        $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');

        if(data['metodo'] != undefined && data['metodo'] == 'abrir')
        {
           eval(data['metodo']+"('"+data['url']+"')");
        }
        else
        {
            var xnData = {};

            if(xnReadonly == 0)
            {
                xnData = { token : xnToken, parent : url_parent };
            }
            else
            {
                xnData = { token : xnToken, parent : url_parent, editing : xnReadonly };
            }

            $.ajax({
                url: backend_url+data['url'],
                type: 'GET',
                dataType: 'json',
                data: xnData,
                success: function(data) {
                    if(data != '' && data != null)
                    {
                        $(parent).html(data);
                        docReady();
                    }
                    else
                    {
                        window.location.reload();
                    }
                },
                error: function ()
                {
                    console.log("Imposible Cargar..");
                }
            });
            return false;
        }
    }
    //actualizar_orden();
}

$(document).ready(function(){
    $(".leftside-navigation").niceScroll({
        cursorcolor: "#1FB5AD",
        cursorborder: "0px solid #fff",
        cursorborderradius: "0px",
        cursorwidth: "5px"
    });

    $(".right-stat-bar").niceScroll({
        cursorcolor: "#1FB5AD",
        cursorborder: "0px solid #fff",
        cursorborderradius: "0px",
        cursorwidth: "5px"
    });
});

$(document).on('click', '.todo-remove', function () {
    $(this).closest("li").remove();
    return false;
});

$(document).ready(docReady());

$(document).on('hover', '.tooltips', function(){
    $(parent).find('.tooltips').tooltip();
});

$(document).on('hover', '.popovers', function(){
    $(parent).find('.popovers').popover({ html: true, trigger: 'click' });
});

function cerrar_sesion()
{
    jConfirm("¿Desea cerrar la sesión?", "Salir del Sistema", function(a) {
        if (a == true)
        {

            $.ajax({
                url: backend_url,
                type: 'POST',
                data: { logout: "true", token: xnToken },
                success: function(data) {
                    window.location.reload();
                },
                error: function(data) {
                    console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
                    return false;
                }
            });
            return false;
        }
    });
}

function idioma(titulo)
{
    $.ajax({
        url: backend_url+'dashboard/idioma/'+titulo,
        type: 'GET',
        data: { token: xnToken },
        success: function(data) {
            window.location.reload(); // Actualizamos la ventana..
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    })
}

function docReady()
{
    xnDropzone = '';

    $('.title-gallery').change(function() {
        var controller = $(this).attr('data-controller'); var id = $(this).attr('data-id'); var value = $(this).val();

        $.ajax({
            url: backend_url + controller + '/actualizar/' + id,
            type: 'POST',
            dataType: 'html',
            data: { titulo: value, parent: url_parent, retorno: 0, valor_retorno: 0 },
            success: function(data) {

                // Imprimiendo en el IFRAME..
                window.frames.oculto.document.clear();
                window.frames.oculto.document.open();
                window.frames.oculto.document.writeln(data);
                window.frames.oculto.document.close();
            },
            error: function(data) {
                console.log(data);
            }
        })

    });

    // Institucional..
    var tipo = $('#tipo').val(); $('#heading_enlace, #heading_descarga, #heading_miniweb, #heading_texto, #section_anexos, #section_repositorio').css('display', 'none');

    if(tipo == 0) // Miniweb..
    {
        $('#heading_miniweb, #section_institucional').css('display', 'block');
    }

    if(tipo == 1) // Texto..
    {
        $('#heading_texto').css('display', 'block'); $('#section_anexos').css('display', 'block');
    }

    if(tipo == 2) // Enlace directo..
    {
        $('#heading_enlace').css('display', 'block');
    }

    if(tipo == 3) // Descarga..
    {
        $('#heading_descarga').css('display', 'block');
    }

    if(tipo == 4)
    {
        $('#section_repositorio').css('display', 'block');
    }

    if(tipo == 5)
    {
        $('#section_institucional').css('display', 'block');
    }

    $(parent).find('#tipo').change(function(e) {
        var tipo = $(this).val(); $('#heading_enlace, #heading_descarga, #heading_miniweb, #heading_texto, #section_anexos, #section_repositorio').css('display', 'none');

        if(tipo == 0) // Enlace directo..
        {
            $('#heading_miniweb, #section_institucional').css('display', 'block');
        }

        if(tipo == 1) // Texto..
        {
            $('#heading_texto').css('display', 'block'); $('#section_anexos').css('display', 'block');
        }

        if(tipo == 2) // Enlace directo..
        {
            $('#heading_enlace').css('display', 'block');
        }

        if(tipo == 3) // Descarga..
        {
            $('#heading_descarga').css('display', 'block');
        }

        if(tipo == 4)
        {
            $('#section_repositorio').css('display', 'block');
        }

        if(tipo == 5)
        {
            $('#section_institucional').css('display', 'block');
        }
    });

    $(parent).find('.summernote').summernote({
        lang: 'es-ES'
    });

    
    $(parent).find('.nestable').nestable().on('change', function(e) {
        
        var values = $(this).nestable('serialize'); console.log(values);

        $.ajax({
            url: backend_url + url_parent + '/actualizar_tree',
            type: 'POST',
            dataType: 'json',
            data: { items: JSON.stringify(values) },
            success: function(data) {
                if(data != '' && data != null)
                {
                    imprimir(data);
                }
                else
                {
                    window.location.reload();
                }
            },
            error: function() {
                console.log("Ocurrió un Error..");
            }
        });
    });

    $(parent).find('.btn-masivo').click(function(){
        $form = $(parent).find('.form_masivo');
        $ruta = $form.attr('action') + '/' + $(this).attr('value') + '_masivo?token=' + xnToken;
        jConfirm("¿Desea continuar con la operación?", "Cuadro de Alerta", function(a)
        {
            if (a == true)
            {
                $form.attr('action', $ruta);
                $form.find('#parent').val(url_parent);
                $form.submit();
            }
        });
    });

    $(parent).find(".sortable").sortable({
        update : function(event, ui) {
            var controller = ui.item.parent().attr('data-controller');
            
            $.ajax({
                url: backend_url+controller+'/actualizar_sortable',
                type: 'POST',
                dataType: 'json',
                data: { items: ui.item.parent().sortable('toArray') },
                success: function(data){
                    if(data != '' && data != null)
                    {
                        imprimir(data);
                    }
                    else
                    {
                        window.location.reload();
                    }
                },
                error: function() {
                    console.log("Ocurrió un error. Por favor, intente nuevamente.");
                }
            });
        }
    });

    $(parent).find('.todo-check label').click(function(){
        $(this).parents('li').children('.todo-title').toggleClass('line-through');
    });

    $(parent).find('.default-date-picker').datepicker({
        format: 'dd-mm-yyyy'
    });

    $(parent).find('.timepicker-24').timepicker({
        autoclose: true,
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    });

    $(parent).find('.spinner').spinner({min: 0});

    $(parent).find('.select').select2();

    $(parent).find('textarea.autogrow').autogrow();

    $(parent).find('.colorpicker-rgba').colorpicker({ format: 'hex' });

    $(parent).find('.sin_retorno').click(function(){
        $('#retorno').attr('value', '0');
    });

    $(parent).find('.con_retorno').click(function(){
        $('#retorno').attr('value', '1');
    });

    $(parent).find('.dynamic-table').dataTable({
        "bPaginate": false,
        "aaSorting": [[ 1, "desc" ]],
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0, 'no-sort' ] }
        ]
    });

    $('#all').click(function() {
        var check = $(this).attr('checked');
        if(check == 'checked')
        {
            $('td > .item').attr('checked', check);
        }
        else
        {
            $('td > .item').removeAttr('checked');
        }
    });

    $(parent).find('.square input').iCheck({
        checkboxClass: 'icheckbox_square',
        radioClass: 'iradio_square',
        increaseArea: '20%' // optional
    });
}

function regresar(elemento)
{
    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');
    $.ajax({
        url: backend_url+'dashboard/regresar',
        type: 'GET',
        dataType: 'json',
        data: { token : xnToken },
        success: function(data) {
            
            console.log(data);

            if(data != '' && data != null)
            {
                imprimir(data);
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}

var xnDropzone = '';

function agregar_dropzone(url)
{
    $('#dropzone').slideToggle();

    if(xnDropzone == '')
    {
        xnDropzone = new Dropzone(".dropzone", { /* options */ });
    }
    else
    {
        $('#dropzone').find('.dropzone').find('.dz-preview').remove();
    }
}

function agregar(url)
{
    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');
    $.ajax({
        url: backend_url+url+'/agregar',
        type: 'GET',
        dataType: 'json',
        data: { token : xnToken, parent: url_parent },
        success: function(data) {
            if(data != '' && data != null)
            {
                $(parent).html(data);
                docReady();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}

function agregar_modal(key, url, item_key, item)
{
    $('#modal').find('.modal-body').html('<div style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></div>');
    $('#modal').find('.modal-footer').css('display', 'none !important');
    $.ajax({
        url: backend_url+url+'/agregar',
        type: 'GET',
        dataType: 'json',
        data: { retorno : 0, token : xnToken, valor_retorno : 0 },
        success: function(data) {
            if(data != '' && data != null)
            {
                $('#modal').find('.modal-body').html(data);
                $('#modal').find('#close_modal').attr('onclick', 'actualizar_select("' + key + "', '" + url + "', '" + item_key + "', '" + item + "');");
                $('#modal').find('.modal-footer').css('display', 'block !important');
                docReady();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    docReady();
}

function actualizar_select(url, id, id_tabla, valor_tabla)
{
    $.ajax({
        url: backend_url+url+'/cargar_opciones',
        type: 'GET',
        dataType: 'html',
        data: { id : id_tabla, valor : valor_tabla, token : xnToken },
        success: function(data) {
            $('#'+id).html(data);
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}

function change_select(evento, url, elemento, hijo)
{
    var value = $(elemento).val();

    $('#'+hijo).attr('disabled', 'disabled');

    $.ajax({
        url: backend_url+url+'/'+evento,
        type: 'POST',
        dataType: 'html',
        data: { id_padre: value },
        success: function(data) {
            $('#'+hijo).html(data);
            $('#'+hijo).removeAttr('disabled');
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
}

function buscar_tab(url, link, retorno, editing)
{
    url_parent = url; $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');

    var xnData = {}; var xnEditing = parseInt(editing);
    
    if(xnEditing == 0)
    {
        xnData = { token : xnToken, id_padre: 0, valor_retorno: retorno, parent: url_parent }
    }
    else
    {
        xnData = { token : xnToken, valor_retorno: retorno, parent: url_parent, editing: xnEditing }
    }

    $.ajax({
        url: backend_url+link,
        type: 'GET',
        dataType: 'json',
        data: xnData,
        success: function(data) {
            if(data != '' && data != null)
            {
                $(parent).html(data); docReady();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
        }
    });
    return false;
}

function activar_tab(url)
{
    url_parent = url; parent = $('#'+url);
}

function abrir(url, elemento)
{
    //var texto = '<i class="fa '+$(elemento).attr('data-icon')+' tooltips" data-title="'+$(elemento).attr('data-title')+'"></i> '+$(elemento).attr('data-title');
    buscar_tab(url, url, 1, 0);
}

function paginar(url, elemento)
{
    //var texto = '<i class="fa '+$(elemento).attr('data-icon')+' tooltips" data-title="'+$(elemento).attr('data-title')+'"></i> '+$(elemento).attr('data-title');
    buscar_tab(url, url, 1, 0);
}

function abrir_pestania(url, elemento)
{
    //var texto = '<i class="fa '+$(elemento).attr('data-icon')+' tooltips" data-title="'+$(elemento).attr('data-title')+'"></i> '+$(elemento).attr('data-title');
    buscar_tab(url, 'dashboard/'+url, 0, 0);
}


function cerrar(elemento)
{
    jConfirm("¿Desea cerrar la ventana?", "Cerrar la Ventana", function(a)
    {
        if (a == true)
        {
            var item = $(elemento).parent().attr('data-id');

            $(elemento).parent().remove();
            $('#'+item).remove();

            $('#item-home').addClass('active'); $('#home').addClass('active');
        }
        else
        {
            return false;
        };
    });
}

function abrir_miga_pan(url)
{
    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: { token : xnToken, parent: url_parent },
        success: function(data) {
            if(data != '' && data != null)
            {
                $(parent).html(data);
                docReady();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
        }
    });
    return false;
}

function redireccionar(url)
{
    window.location.href = url;
}

function actualizar(url, id)
{
    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');

    $.ajax({
        url: backend_url+url+'/actualizar/'+id,
        type: 'GET',
        dataType: 'json',
        data: { token : xnToken, parent : url_parent },
        success: function(data) {
            if(data != '' && data != null)
            {
                $(parent).html(data);
                docReady();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}

function actualizar_item(url, id)
{
    xnReadonly = 1; buscar_tab(url, url+'/actualizar/'+id, 0, 1);
}

function visualizar(url, id)
{
    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');
    $.ajax({
        url: backend_url+url+'/visualizar/'+id,
        type: 'GET',
        dataType: 'json',
        data: { token : xnToken, parent : url_parent },
        success: function(data) {
            if(data != '' && data != null)
            {
                $(parent).html(data);
                docReady();
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}

function eliminar(url, id)
{
    jConfirm("¿Desea eliminar el registro?", "Eliminar el Registro", function(a)
    {
        if (a == true)
        {
            $.ajax({
                url: backend_url+url+"/eliminar/"+id,
                type: 'GET',
                dataType: 'json',
                data: { token : xnToken },
                success: function(data) {
                    if(data != '' && data != null)
                    {
                        imprimir(data);
                    }
                    else
                    {
                        window.location.reload();
                    }
                },
                error: function(data) {
                    window.location.href = backend_url;
                }
            });
            return false;
        }
        else
        {
            return false;
        };
    });
}

function publicar(url, id, value)
{
    $(parent).find('.message').css('display', 'none');

    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');

    $.ajax({
        url: backend_url+url+'/publicar/'+id,
        type: 'POST',
        dataType: 'json',
        data: { activado: value, token : xnToken },
        success: function(data) {
            if(data != '' && data != null)
            {
                imprimir(data);
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}

function action_update(url, key, id, value)
{
    $(parent).find('.message').css('display', 'none');

    $(parent).html('<section class="panel" style="text-align:center;"><img src="'+backend_view+'loading.gif" style="margin:10px;text-align:center;" /></section>');

    $.ajax({
        url: backend_url+url+'/action_update/'+id,
        type: 'POST',
        dataType: 'json',
        data: { valor: value, token : xnToken, campo: key },
        success: function(data) {
            if(data != '' && data != null)
            {
                imprimir(data);
            }
            else
            {
                window.location.reload();
            }
        },
        error: function() {
            console.log("Ocurrió un error. Por favor, contacte al desarrollador.");
            return false;
        }
    });
    return false;
}