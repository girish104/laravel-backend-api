/*!
 * jQuery Multi Selection
 * https://github.com/xenialaw/jQuery-Multi-Selection
 *
 * Includes jQuery Library
 * http://www.jquery.com/
 *
 * 
 * Copyright 2018 © Soyo Solution Company. and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 *
 * Version           : v1.0
 * Author            : Xenia Law
 * Created date      : 2018-09-14
 * Last updated date : 2018-09-19
 */

(function ( $ ) {
    $.fn.jQueryMultiSelection = function(options) {
        
        var thisEle = this;
        var _opts = $.extend({
                        enableDynamicAddContent : false,
                        ajaxSourceUrl           : "../dist/list.json",
                        btnGetJson              : "#btn-ajax",
                        selectMeunFrom          : ".from-panel select",
                        selectMeunTo            : ".to-panel select",
                        
                        btnMoveAllRight         : ".btn-move-all-right",
                        btnMoveSelectedRight    : ".btn-move-selected-right",
                        btnMoveAllLeft          : ".btn-move-all-left",
                        btnMoveSelectedLeft     : ".btn-move-selected-left",
                        btnDelete               : ".btn-delete",
                        btnMoveUp               : ".btn-up",
                        btnMoveDown             : ".btn-down",
                        
                        htmlMoveAllRight        : "&rsaquo;&rsaquo;",
                        htmlMoveSelectedRight   : "&rsaquo;",
                        htmlMoveAllLeft         : "&lsaquo;&lsaquo;",
                        htmlMoveSelectedLeft    : "&lsaquo;",
                        htmlDelete              : "Delete",
                        htmlMoveUp              : "Up",
                        htmlMoveDown            : "Down",
                    }, options);
        
        jQueryMultiSelection = {
            init: function(){
                setInterface();
                setDeleteBtnListener();
                setUpBtnListener();
                setDownBtnListener();
                setMoveBtnsListener();
                if(_opts.enableDynamicAddContent) setAjaxBtnListener();
            }
        };
        
        function setInterface(){
            $(_opts.btnMoveAllRight).html(_opts.htmlMoveAllRight);
            $(_opts.btnMoveSelectedRight).html(_opts.htmlMoveSelectedRight);
            $(_opts.btnMoveAllLeft).html(_opts.htmlMoveAllLeft);
            $(_opts.btnMoveSelectedLeft).html(_opts.htmlMoveSelectedLeft);
            $(_opts.btnDelete).html(_opts.htmlDelete);
            $(_opts.btnMoveUp).html(_opts.htmlMoveUp);
            $(_opts.btnMoveDown).html(_opts.htmlMoveDown);
        }
        
        function setDeleteBtnListener(){
            $(_opts.btnDelete).click( function () { 
                $(this).parent().prev().find("select option:selected").each(function(){
                    $(this).remove();
                });
            });
        }
        
        function setUpBtnListener(){
            $(_opts.btnMoveUp).click( function () { 
                $(this).parent().prev().find("select option:selected").each(function(){
                    var options = $(this).parent().find("option");
                    var newPos  = options.index(this) - 1;
                    if (newPos > -1) {
                        options.eq(newPos).before("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                        $(this).remove();
                    }
                });
            });
        }
        
        function setDownBtnListener(){
            $(_opts.btnMoveDown).click( function () { 
                $(this).parent().prev().find("select option:selected").each(function(){
                    var options = $(this).parent().find("option");
                    var newPos  = options.index(this) + 1;
                    if (newPos < options.size()) {
                        options.eq(newPos).after("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                        $(this).remove();
                    }
                });
            });
        }
        
        function setMoveBtnsListener(){
            $(_opts.btnMoveAllRight).click(function(){ _multiTransfer(this, true, true)});
            $(_opts.btnMoveSelectedRight).click(function(){ _multiTransfer(this, false, true)});
            $(_opts.btnMoveAllLeft).click(function(){ _multiTransfer(this, true, false)});
            $(_opts.btnMoveSelectedLeft).click(function(){_multiTransfer(this, false, false)});
        }
        
        function _multiTransfer(btnEle, isAll, isToRight){
            var nextList = $(btnEle).parent().next().find("select");
            var prevList = $(btnEle).parent().prev().find("select");
            var fromList = isToRight ? prevList: nextList;
            var toList   = isToRight ? nextList: prevList;
            var selector = isAll     ? fromList.find("option"): fromList.find("option:selected");
            
            selector.each(function() {
                $(this).remove();
                toList.append($(this));
            });
        }
        
        function setAjaxBtnListener(){
            $(_opts.btnGetJson).one( "click", function() {
                var thisBtnEle = $(this);
                $.ajax({
                    url: _opts.ajaxSourceUrl,
                    dataType: "json",
                    data: { format: "json"},
                    success: function( response ) {
                        var tempStr = "";
                        var jsonItemsSize = Object.size(response);
                        for(var i =0; i<jsonItemsSize; i++){
                            tempStr += '<option title="'+i+'" value="'+response[i].value+'">'+response[i].text+"</option>";
                        }
                        thisEle.find(_opts.selectMeunFrom).append(tempStr);
                    },
                    complete:function(){},
                    error: function(  jqXHR,textStatus,errorThrown ) {}
                });
            });
        }
        
        Object.size = function(obj) {
            var size = 0, key;
            for (key in obj) { if (obj.hasOwnProperty(key)) size++; }
            return size;
        };
        
        jQueryMultiSelection.init();
        
    };
}( jQuery ));