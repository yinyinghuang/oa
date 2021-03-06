/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args); 
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var CURRENT_URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('.menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer'),
    $SEARCH = $('#show-search'),
    $SEARCH_BOX = $('.search_box');

// Sidebar
$(document).ready(function() {
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.outerHeight(),
            footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
            leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
        // normalize content
        contentHeight -= $NAV_MENU.height() + footerHeight;

        $RIGHT_COL.css('min-height', contentHeight);
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }
            
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });

    // toggle small or large menu
    $MENU_TOGGLE.on('click', function() {
        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
        }

        $BODY.toggleClass('nav-md nav-sm');

        setContentHeight();
    });

    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('current-page')/*.parents('ul').slideDown(function() {
        setContentHeight();
    })*/.parent().addClass('active');

    // recompute content when resizing
    $(window).smartresize(function(){  
        setContentHeight();
    });

    setContentHeight();

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }
});
// /Sidebar

// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
// /Tooltip

// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// Switchery
$(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});
// /Switchery

// iCheck
$(document).ready(function() {
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
});
// /iCheck

// Table
$('table input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}

// Accordion
$(document).ready(function() {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });

    $(document).ajaxStart(function(){
        NProgress.start();
    });

    $(document).ajaxStop(function(){
        NProgress.done();
    })
}

//toggle search box on xs screen
$SEARCH.on('click', function(){
    if($SEARCH_BOX.is(':hidden')){
        $SEARCH_BOX.slideDown();
    }else{
        $SEARCH_BOX.slideUp();
    }
});
// $('body').on('touchstart', function(e) {
//     var touch = e.originalEvent,
//         startX = touch.changedTouches[0].pageX,
//         startY = touch.changedTouches[0].pageY;
//     $(this).on('touchmove', function(e) {
        
//         touch = e.originalEvent.touches[0] ||
//             e.originalEvent.changedTouches[0];
//         delX = touch.pageX - startX;
//         delY = touch.pageY - startY;
//         if (Math.abs(delX) > Math.abs(delY)) {
//             if (delX > 150) {//右划显示侧栏
//                 if ($BODY.hasClass('nav-md')) {
//                     $BODY.attr('class','nav-sm');
//                     $SIDEBAR_MENU.find('li.active-sm ul').show();
//                     $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
//                 }
//             } else if (delX < - 150) {//左划隐藏侧栏
//                 if ($BODY.hasClass('nav-sm')) {
//                     $BODY.attr('class','nav-md');
//                     $SIDEBAR_MENU.find('li.active ul').hide();
//                     $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
//                 }
//             }
//         }
        
//     });
// });

var toggle;
        $(document).on('visibilitychange', function () {
            
            if(!document.hidden) {//页面切换为可见时，获取最新消息及任务
              if ((new Date() - toggle)/1000 > 60) {
                $.ajax({
                  type : 'post',
                  url : '/tasks/get-new',
                  data : {
                    time : toggle
                  },
                  success: function(data){
                    data = JSON.parse(data);

                    for(var i in data.notices) {
                      var cur = data.notices[i]; 
                      new PNotify({
                          title: '通知<small class="pull-right" style="color:#fff">' + cur.model + '<small>',
                          text: '<a href="' + cur.deal.url + '" style="color:#fff">' + cur.item + '</a>',
                          icon: 'glyphicon glyphicon-envelope',
                          type: 'info',
                          styling: 'bootstrap3',
                          delay: 3000,
                          width:'280px'
                      });
                    }
                    for(var i in data.tasks) {
                      var cur = data.tasks[i]; 
                      new PNotify({
                          title: '任务<small class="pull-right" style="color:#fff">' + cur.model + '<small>',
                          text: '<a href="' + cur.deal.url + '" style="color:#fff">' + cur.item + '</a>',
                          icon: 'glyphicon glyphicon-tasks',
                          type: 'notice',
                          styling: 'bootstrap3',
                          delay: 3000,
                          width:'280px'
                      });
                    }
                  },
                  error : function(){

                  }
                });
              }
            } else {//记录窗口不可见时间
              toggle = new Date();
            }
        });