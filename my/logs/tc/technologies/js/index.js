$(function(){
    // MOVE MARKER
    var movedMarker = '___moved';
    // HASH FLG
    var hashMovedStatus = false;
    // -------------------------------------------------------------------------------------------------------
    // COMMON
    // -------------------------------------------------------------------------------------------------------
    var COMMON = {
        cache : {
            _w : $(window),
            _d : $(document),
            _b : $('body'),
            _r : null
        },
        config : {
            userAgent : window.navigator.userAgent.toLowerCase(),
            appVersion : window.navigator.appVersion.toLowerCase(),
            browser : {
                name : null,
                support : {
                    transform : null,
                    transition : null
                }
            },
            minW : null,
            maxW : null
        },
        init : function(minW, maxW){
            if(COMMON.config.userAgent.indexOf('android') != -1){
                COMMON.config.browser.name = 'android';
                if(COMMON.config.userAgent.indexOf('mobile') == -1){
                    COMMON.config.browser.name = 'tablet';
                }
            }else if(COMMON.config.userAgent.indexOf('firefox') != -1){
                COMMON.config.browser.name = 'firefox';
            }else if(COMMON.config.userAgent.indexOf('chrome') != -1){
                COMMON.config.browser.name = 'chrome';
            }else if(COMMON.config.userAgent.indexOf('opera') != -1){
                COMMON.config.browser.name = 'opera';
            }else if(COMMON.config.userAgent.indexOf('iphone') != -1){
                COMMON.config.browser.name = 'iphone';
            }else if(COMMON.config.userAgent.indexOf('ipad') != -1){
                COMMON.config.browser.name = 'ipad';
            }else if(COMMON.config.userAgent.indexOf('safari') != -1){
                COMMON.config.browser.name = 'safari';
            }else if(COMMON.config.userAgent.indexOf('msie') != -1){
                if(COMMON.config.appVersion.indexOf('msie 8.') != -1){
                    COMMON.config.browser.name = 'IE8';
                }else if(COMMON.config.appVersion.indexOf('msie 9.') != -1){
                    COMMON.config.browser.name = 'IE9';
                }else if(COMMON.config.appVersion.indexOf('msie 10.') != -1){
                    COMMON.config.browser.name = 'IE10';
                }else{
                    COMMON.config.browser.name = 'IERegacy';
                }
            }else{
                if(COMMON.config.userAgent.match(/trident/)){
                    COMMON.config.browser.name = 'IE11';
                }else{
                    COMMON.config.browser.name = 'unknown';
                }
            }
            COMMON.config.browser.support = {
                transform : typeof COMMON.cache._b.css('transform') === 'string',
                transition : typeof COMMON.cache._b.css('transitionProperty') === 'string'
            };
            COMMON.config.minW = minW || 0;
            if(COMMON.config.minW != 0){
                COMMON.cache._b.css('min-width', minW + 'px');
            }
            COMMON.config.maxW = maxW;
            if(COMMON.config.browser.name === 'firefox'){
                COMMON.cache._r = $('html');
            }else if(COMMON.config.browser.name === 'safari' || COMMON.config.browser.name === 'chrome' || COMMON.config.browser.name === 'android' || COMMON.config.browser.name === 'tablet'){
                COMMON.cache._r = $('body');
            }else if(COMMON.config.browser.name.indexOf('IE') != -1){
                COMMON.cache._r = $('html');
            }else{
                COMMON.cache._r = $('html, body');
            }
        },
        handler : {
            check : {
                minW : function(){
                    return COMMON.cache._w.width() > COMMON.config.minW;
                },
                domExsist : function(obj){
                    if(obj !== undefined && obj !== null && obj.size() > 0){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Hash Handler
    // -------------------------------------------------------------------------------------------------------
    var HashController = {
        config : {
            hash : null,
            stack : {
                noHashCallBack : function(){},
                hashCallBack : function(){}
            }
        },
        handler : {
            filter : function(){
                var hash = location.hash;
                if(hash && hash !== '#'){
                    HashController.config.hash = hash;
                    return true;
                }else{
                    HashController.config.hash = null;
                    return false;
                }
            },
            activate : function(){
                if(HashController.handler.filter()){
                    HashController.config.stack.hashCallBack(HashController.config.hash);
                }else{
                    HashController.config.stack.noHashCallBack();
                }
            }
        },
        bind : function(){
            COMMON.cache._w.on('hashchange', function(){
                HashController.handler.activate();
            });
        },
        init : function(callBacks, hashCheckFlg){
            $.extend(HashController.config.stack, callBacks);
            if(hashCheckFlg){
                HashController.handler.activate();
            }
            HashController.bind();
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Device
    // -------------------------------------------------------------------------------------------------------
    var DeviceHandler = {
        config : {
            cache : {
                spDeviceFlg : false
            },
            switchLimit : 800
        },
        bind : function(){
            if(COMMON.cache._w.width() < DeviceHandler.config.switchLimit){
                DeviceHandler.config.cache.spDeviceFlg = true;
            }else{
                DeviceHandler.config.cache.spDeviceFlg = false;
            }
        }
    };

    // -------------------------------------------------------------------------------------------------------
    // For Body Scroll
    // -------------------------------------------------------------------------------------------------------
    var BodyScrollHandler = {
        config : {
            currentStatus : false,
            markerClasses : ['nonScroll', 'scroll'],
            forcedStopFlg : false
        },
        watch : function(){
            COMMON.cache._b.on('mousewheel', function(evt){
                if(BodyScrollHandler.config.forcedStopFlg){
                    evt.preventDefault();
                    evt.stopPropagation();
                }
            });
        },
        refineZero : function(){
            COMMON.cache._w.scrollTop(0);
        },
        reset : function(){
            for(var i = 0, il = BodyScrollHandler.config.markerClasses.length; i < il; i++){
                COMMON.cache._b.removeClass(BodyScrollHandler.config.markerClasses[i]);
            }
        },
        bind : function(scrollFlg){
            BodyScrollHandler.reset();
            COMMON.cache._b.addClass(BodyScrollHandler.config.markerClasses[scrollFlg]);
            BodyScrollHandler.config.currentStatus = scrollFlg;
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Header Menu
    // -------------------------------------------------------------------------------------------------------
    var HeaderMenuHandler = {
        config : {
            cache : {
                headerW : null
            },
            interval : {
                menu : 800
            },
            rootTrigger : $('#header'),
            root : $('#menuWrapper'),
            dummyBg : $('#headerDummyBg'),
            menu : $('#menu'),
            marker : '___opened'
        },

        handler : {
            display : function(target, showFlg){
                if(showFlg){
                    target
                        .velocity('stop')
                        .velocity(
                            {
                                'width' : '100%'
                            },
                            {
                                'duration' : HeaderMenuHandler.config.interval.menu
                            }
                        );
                }else{
                    target
                        .velocity('stop')
                        .velocity(
                            {
                                'width' : HeaderMenuHandler.config.cache.headerW + 'px'
                            },
                            {
                                'duration' : HeaderMenuHandler.config.interval.menu
                            }
                        );
                }
            }
        },
        bind : function(){
            HeaderMenuHandler.config.rootTrigger.hover(
                function(){
                    if(!HeaderMenuHandler.config.root.hasClass(HeaderMenuHandler.config.marker)){
                        HeaderMenuHandler.handler.display(HeaderMenuHandler.config.menu, true);
                        HeaderMenuHandler.handler.display(HeaderMenuHandler.config.dummyBg, true);
                    }
                },
                function(){
                    if(!HeaderMenuHandler.config.root.hasClass(HeaderMenuHandler.config.marker)){
                        HeaderMenuHandler.handler.display(HeaderMenuHandler.config.menu, false);
                        HeaderMenuHandler.handler.display(HeaderMenuHandler.config.dummyBg, false);
                    }
                }
            );
        },
        init : function(){
            HeaderMenuHandler.config.cache.headerW = HeaderMenuHandler.config.dummyBg.width();
            if(COMMON.config.browser.name.indexOf('IE') != -1){
                HeaderMenuHandler.config.cache.headerW += 20;
            }
            HeaderMenuHandler.bind();
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Tab
    // -------------------------------------------------------------------------------------------------------
    var TabContentHandler = {
        config : {
            cache : {
                currentIdx : null
            },
            triggersRoot : $('#tabs'),
            triggers : $('.tabLink'),
            contents : $('[id^="tabContent"]'),
            key : 'tab-idx',
            marker : 'currentTab',
            interval : 1000
        },
        handler : {
            display : function(trigger, visibleIdx){
                TabContentHandler.config.triggers.each(function(idx){
                    $(this).removeClass(TabContentHandler.config.marker);
                    if(visibleIdx == idx){
                        $(this).addClass(TabContentHandler.config.marker);
                    }
                });
                TabContentHandler.config.contents.each(function(){
                    $(this).css(
                        {
                            'display' : 'none',
                            'opacity' : 0
                        }
                    );
                });
                TabContentHandler.config.contents.eq(visibleIdx)
                    .css('display', 'block')
                    .velocity(
                       {
                            'opacity' : 1
                        },
                        {
                            'begin' : function(){
                                TabContentHandler.config.cache.currentIdx = visibleIdx;
                            },
                            'duration' : TabContentHandler.config.interval,
                            'complete' : function(){}
                         }
                    );
            }
        },
        resize : function(mvH){
            TabContentHandler.config.triggersRoot.css('top', mvH + 'px');
        },
        bind : function(){
            TabContentHandler.config.triggers.each(function(){
                $(this).on('click', function(){
                    var tmpTabIdx = parseInt($(this).data(TabContentHandler.config.key), 10) - 1;
                    if(TabContentHandler.config.cache.currentIdx != tmpTabIdx){
                        TabContentHandler.handler.display($(this), tmpTabIdx);
                    }
                })
            });
        },
        init : function(){
            TabContentHandler.handler.display(TabContentHandler.config.triggers.eq(0), 0);
            TabContentHandler.bind();
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Main View
    // -------------------------------------------------------------------------------------------------------
    var MainViewHandler = {
        config : {
            cache : {
                partsH : null,
                footerH : null,
                spHeaderH : null,
                dummyFooter : '<div class="dummyFooter">###</div>'
            },
            interval : {
                mv : 800
            },
            num : null,
            root : $('#mv'),
            parts : null,
            contents : null,
            footer : $('#footer')
        },
        handler : {
            bindEvent : function(){},
            adaptFooterToEachContent : function(){
                MainViewHandler.config.contents.each(function(){
                    $(this).append(MainViewHandler.config.cache.dummyFooter);
                });
            },
            shoMvContent : function(contentIdx){
                MainViewHandler.config.contents.eq(contentIdx)
                    .css(
                        {
                            'paddingTop' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.partsH + MainViewHandler.config.cache.spHeaderH : MainViewHandler.config.cache.partsH) + 'px',
                            'display' : 'block'
                        }
                    )
                    .velocity(
                        {
                            'opacity' : 1
                        },
                        {
                            'duration' : MainViewHandler.config.interval.mv,
                            'complete' : function(){
                                BodyScrollHandler.bind(1);

                            }
                        }
                    );
            }
        },
        show : function(visibleIdx, animateFlg, warpFlg){
            hashMovedStatus = false;
            BodyScrollHandler.bind(0);
            BodyScrollHandler.refineZero();
            var entityIdx = visibleIdx - 1;
            switch(entityIdx){
                case 0:
                    var tmpAnimateH = (MainViewHandler.config.cache.partsH * MainViewHandler.config.num) + MainViewHandler.config.cache.footerH;
                    if(animateFlg){
                        MainViewHandler.config.parts.eq(1).velocity(
                            {
                                'top' : tmpAnimateH + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                        MainViewHandler.config.parts.eq(2).velocity(
                            {
                                'top' : tmpAnimateH + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                    }else{
                        MainViewHandler.config.parts.eq(1).css(
                            {
                                'top' : tmpAnimateH + 'px',
                                'display' : 'none'
                            }
                        );
                        MainViewHandler.config.parts.eq(2).css(
                            {
                                'top' : tmpAnimateH + 'px',
                                'display' : 'none'
                            }
                        );
                    }
                    MainViewHandler.handler.shoMvContent(0);
                    break;
                case 1:
                    var tmpAnimateH = (MainViewHandler.config.cache.partsH * MainViewHandler.config.num) + MainViewHandler.config.cache.footerH;
                    if(animateFlg){
                        MainViewHandler.config.parts.eq(0).velocity(
                            {
                                'top' : -1 * MainViewHandler.config.cache.partsH + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                        MainViewHandler.config.parts.eq(2).velocity(
                            {
                                'top' : tmpAnimateH + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                        MainViewHandler.config.parts.eq(1).velocity(
                            {
                                'top' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.spHeaderH : 0) + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    MainViewHandler.handler.shoMvContent(1);
                                }
                            }
                        );
                    }else{
                        MainViewHandler.config.parts.eq(0).css(
                            {
                                'top' : -1 * MainViewHandler.config.cache.partsH + 'px',
                                'display' : 'none'
                            }
                        );
                        MainViewHandler.config.parts.eq(2).css(
                            {
                                'top' : tmpAnimateH + 'px',
                                'display' : 'none'
                            }
                        );
                        MainViewHandler.config.parts.eq(1).css(
                            {
                                'top' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.spHeaderH : 0) + 'px'
                            }
                        );
                        MainViewHandler.handler.shoMvContent(1);
                    }
                    break;
                case 2:
                    if(animateFlg){
                        MainViewHandler.config.parts.eq(0).velocity(
                            {
                                'top' : -1 * MainViewHandler.config.cache.partsH + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                        MainViewHandler.config.parts.eq(1).velocity(
                            {
                                'top' : -1 * (MainViewHandler.config.cache.partsH * 2.5) + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv * 2,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                        MainViewHandler.config.parts.eq(2).velocity(
                            {
                                'top' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.spHeaderH : 0) + 'px',
                                'height' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.partsH : MainViewHandler.config.cache.partsH + 85) + 'px'
                            },
                            {
                                'duration' : MainViewHandler.config.interval.mv,
                                'complete' : function(){
                                    MainViewHandler.handler.shoMvContent(2);
                                }
                            }
                        );
                    }else{
                        MainViewHandler.config.parts.eq(0).css(
                            {
                                'top' : -1 * MainViewHandler.config.cache.partsH + 'px',
                                'display' : 'none'
                            }
                        );
                        MainViewHandler.config.parts.eq(1).css(
                            {
                                'top' : -1 * (MainViewHandler.config.cache.partsH * 2.5) + 'px',
                                'display' : 'none'
                            }
                        );
                        MainViewHandler.config.parts.eq(2).css(
                            {
                                'top' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.spHeaderH : 0) + 'px',
                                'height' : (DeviceHandler.config.cache.spDeviceFlg ? MainViewHandler.config.cache.partsH : MainViewHandler.config.cache.partsH + 85) + 'px'
                            }
                        );
                        MainViewHandler.handler.shoMvContent(2);
                    }
                    break;
            }
            MainViewHandler.config.footer.velocity(
                {
                    'bottom' : (-1 * MainViewHandler.config.cache.footerH) + 'px'
                },
                {
                    'duration' : MainViewHandler.config.interval.mv
                }
            );
            if(warpFlg){
                COMMON.cache._b.velocity(
                    {
                        'opacity' : 1
                    },
                    {
                        'delay' : animateFlg ? MainViewHandler.config.interval.mv * 2 : 0,
                        'duration' : 800,
                        'complete' : function(){}
                    }
                );
            }
            COMMON.cache._b.removeClass(movedMarker);
            HeaderMenuHandler.config.root.removeClass(HeaderMenuHandler.config.marker);
            BodyScrollHandler.config.forcedStopFlg = false;
            hashMovedStatus = true;
        },
        reset : function(visibleIdx, animateFlg, warpFlg){
            hashMovedStatus = false;
            BodyScrollHandler.bind(0);
            COMMON.cache._b
                .velocity(
                    {
                        'opacity' : 0
                    },
                    {
                        'duration' : 800,
                        'complete' : function(){
                            MainViewHandler.resize(DeviceHandler.config.cache.spDeviceFlg);
                            if(visibleIdx != 0){
                                MainViewHandler.config.contents.each(function(idx){
                                    if(visibleIdx != idx + 1){
                                        $(this).css(
                                            {
                                                'opacity' : 0,
                                                'display' : 'none'
                                            }
                                        );
                                    }else{
                                        $(this).css(
                                            {
                                                'opacity' : 1,
                                                'display' : ''
                                            }
                                        );
                                    }
                                });
                                MainViewHandler.config.parts.each(function(idx){
                                    if(visibleIdx != idx + 1){
                                        $(this).css(
                                            {
                                                'opacity' : 0,
                                                'display' : 'none'
                                            }
                                        );
                                    }else{

                                        $(this).css(
                                            {
                                                'opacity' : 1,
                                                'display' : ''
                                            }
                                        );
                                    }
                                });
                                MainViewHandler.show(visibleIdx, animateFlg, warpFlg);
                            }else{
                                MainViewHandler.config.contents.each(function(idx){
                                    $(this).css(
                                        {
                                            'opacity' : 0,
                                            'display' : 'none'
                                        }
                                    );
                                });
                                MainViewHandler.config.parts.each(function(idx){
                                    $(this).css(
                                        {
                                            'opacity' : 1,
                                            'display' : '',
                                            'height' : MainViewHandler.config.cache.partsH + 'px',
                                            'top' : (DeviceHandler.config.cache.spDeviceFlg ? ((MainViewHandler.config.cache.partsH * idx) + 40) : (MainViewHandler.config.cache.partsH * idx)) + 'px'
                                        }
                                    );
                                });
                                MainViewHandler.config.footer.css('bottom', '0px');
                                COMMON.cache._b.velocity(
                                    {
                                        'opacity' : 1
                                    },
                                    {
                                        'duration' : 800,
                                        'complete' : function(){
                                            hashMovedStatus = true;
                                        }
                                    }
                                );
                            }
                        }
                    }
                );
        },
        resize : function(spDeviceFlg){
            MainViewHandler.config.cache.footerH = MainViewHandler.config.footer.height();
            if(spDeviceFlg){
                MainViewHandler.config.cache.partsH = Math.ceil((COMMON.cache._w.height() - MainViewHandler.config.cache.footerH - MainViewHandler.config.cache.spHeaderH) / MainViewHandler.config.num);
                if(BodyScrollHandler.config.currentStatus){
                    MainViewHandler.config.parts.each(function(idx){
                        $(this).css(
                            {
                                'height' : MainViewHandler.config.cache.partsH + 'px',
                                'top' : MainViewHandler.config.cache.spHeaderH + 'px'
                            }
                        );
                    });
                }else{
                    MainViewHandler.config.parts.each(function(idx){
                        if(idx != 2){
                            $(this).css(
                                {
                                    'height' : MainViewHandler.config.cache.partsH + 'px',
                                    'top' : ((MainViewHandler.config.cache.partsH * idx) + MainViewHandler.config.cache.spHeaderH) + 'px'
                                }
                            );
                        }else{
                            $(this).css(
                                {
                                    'height' : (spDeviceFlg ? MainViewHandler.config.cache.partsH : MainViewHandler.config.cache.partsH + 85) + 'px',
                                    'top' : ((MainViewHandler.config.cache.partsH * idx) + MainViewHandler.config.cache.spHeaderH) + 'px'
                                }
                            );
                        }

                    });
                }
                MainViewHandler.config.contents.each(function(){
                    $(this).css(
                        'paddingTop',
                        MainViewHandler.config.cache.partsH + MainViewHandler.config.cache.spHeaderH + 'px'
                    );
                });
                TabContentHandler.resize(MainViewHandler.config.cache.partsH);
            }else{
                MainViewHandler.config.cache.partsH = Math.ceil((COMMON.cache._w.height() - MainViewHandler.config.cache.footerH) / MainViewHandler.config.num);
                if(BodyScrollHandler.config.currentStatus){
                    MainViewHandler.config.parts.each(function(idx){
                        if(idx != 2){
                            $(this).css(
                                {
                                    'height' : MainViewHandler.config.cache.partsH + 'px',
                                    'top' : '0px'
                                }
                            );
                        }else{
                            $(this).css(
                                {
                                    'height' : (spDeviceFlg ? MainViewHandler.config.cache.partsH : MainViewHandler.config.cache.partsH + 85) + 'px',
                                    'top' : '0px'
                                }
                            );
                        }
                    });
                }else{
                    MainViewHandler.config.parts.each(function(idx){
                        $(this).css(
                            {
                                'height' : MainViewHandler.config.cache.partsH + 'px'
                                //'top' : (MainViewHandler.config.cache.partsH * idx) + 'px'
                            }
                        );
                    });
                }
                MainViewHandler.config.contents.each(function(){
                    $(this).css(
                        'paddingTop',
                        MainViewHandler.config.cache.partsH + 'px'
                    );
                });
                TabContentHandler.resize(MainViewHandler.config.cache.partsH);
            }
        },
        bind : function(){
            MainViewHandler.config.parts.each(function(){
                $(this).on('click', function(){
                    if(BodyScrollHandler.config.currentStatus == 0){
                        COMMON.cache._b.addClass(movedMarker);
                    }
                });
            });
        },
        init : function(){
            MainViewHandler.config.parts = MainViewHandler.config.root.find('.mvPart');
            MainViewHandler.config.contents = MainViewHandler.config.root.find('.mvContent');
            MainViewHandler.config.num = MainViewHandler.config.parts.size();
            MainViewHandler.config.cache.spHeaderH = $('#spHeader').height();
            MainViewHandler.config.cache.dummyFooter = MainViewHandler.config.cache.dummyFooter.replace(
                '###',
                MainViewHandler.config.footer.html()
            );
            MainViewHandler.resize(DeviceHandler.config.cache.spDeviceFlg);
            MainViewHandler.handler.adaptFooterToEachContent();
            MainViewHandler.bind();
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Modal
    // -------------------------------------------------------------------------------------------------------
    var ModalHandler = {
        config : {
            root : $('#modal'),
            close : $('.closeModal'),
            spClose : $('#spCloseModal'),
            open : $('.openModal'),
            subTriggers : $('.innerLink'),
            spOpen : $('.spOpenModal'),
            content : $('#modalContent'),
            interval : {
                show : 1000,
                hide : 500
            },
            visibleFlg : false
        },
        handler : {
            display : function(showFlg, spDeviceFlg){
                HeaderMenuHandler.config.root.removeClass(HeaderMenuHandler.config.marker);
                if(spDeviceFlg){
                    DummyScrollHandler.handler.reset();
                }
                if(showFlg){
                    HeaderMenuHandler.config.root.addClass(HeaderMenuHandler.config.marker);
                    ModalHandler.config.visibleFlg = true;
                    BodyScrollHandler.config.forcedStopFlg = true;
                    ModalHandler.config.root
                        .css('display', 'block')
                        .velocity(
                            {
                                'opacity' : 1
                            },
                            {
                                'duration' : ModalHandler.config.interval.show
                            }
                        );
                    if(!spDeviceFlg){
                        ModalHandler.config.close
                            .css('display', 'block')
                            .velocity(
                                {
                                    'opacity' : 1
                                },
                                {
                                    'duration' : ModalHandler.config.interval.show
                                }
                            );
                        }
                }else{
                    ModalHandler.config.visibleFlg = false;
                    BodyScrollHandler.config.forcedStopFlg = false;
                    ModalHandler.config.root
                        .velocity(
                            {
                                'opacity' : 0
                            },
                            {
                                'duration' : ModalHandler.config.interval.hide,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                    ModalHandler.config.close
                        .velocity(
                            {
                                'opacity' : 0
                            },
                            {
                                'duration' : ModalHandler.config.interval.hide,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                }
                            }
                        );
                    HeaderMenuHandler.handler.display(HeaderMenuHandler.config.menu, false);
                    HeaderMenuHandler.handler.display(HeaderMenuHandler.config.dummyBg, false);

                }
            }
        },
        bind : function(){
            ModalHandler.config.open.on('click', function(){
                if(hashMovedStatus){
                    if(!ModalHandler.config.visibleFlg){
                        ModalHandler.handler.display(true, DeviceHandler.config.cache.spDeviceFlg);
                    }else{
                        ModalHandler.handler.display(false, DeviceHandler.config.cache.spDeviceFlg);
                    }
                }
            });
            ModalHandler.config.spOpen.on('click', function(){
                ModalHandler.handler.display(false, DeviceHandler.config.cache.spDeviceFlg);
            });
            ModalHandler.config.subTriggers.on('click', function(){
                ModalHandler.handler.display(false, DeviceHandler.config.cache.spDeviceFlg);
                HeaderMenuHandler.config.root.removeClass(HeaderMenuHandler.config.marker);
            });
            ModalHandler.config.close.on('click', function(){
                ModalHandler.handler.display(false, DeviceHandler.config.cache.spDeviceFlg);
            });
            ModalHandler.config.spClose.on('click', function(){
                ModalHandler.handler.display(false, DeviceHandler.config.cache.spDeviceFlg);
            });
        },
        resize : function(spDeviceFlg){
            if(spDeviceFlg){
                ModalHandler.config.close.css('display', 'none');
                ModalHandler.config.content.css(
                    'height',
                    (COMMON.cache._w.height() - MainViewHandler.config.cache.spHeaderH) + 'px'
                );
            }else{
                ModalHandler.config.content.css(
                    'height',
                    (window.innerHeight || $(window).height()) + 'px'
                );
            }
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Media Modal
    // -------------------------------------------------------------------------------------------------------
    var MediaModalHandler = {
        config : {
            root : $('#mediaModal'),
            content : null,
            viewContent: $('#mediaContent'),
            openModal : $('.mediaModalTrigger'),
            closeModal : $('#closeMediaModal'),
            interval : {
                open : 800,
                close : 200
            },
            key : 'media-modal-type',
            exceptionKey : 'media-modal-special-img',
            marker : '___frame',
            marker2 : 'whiteBg'
        },
        handler : {
            adaptContent : function(info){
                MediaModalHandler.config.viewContent.html();
                MediaModalHandler.config.viewContent.html(info);
            },
            display : function(trigger, showFlg){
                MediaModalHandler.config.viewContent.removeClass(MediaModalHandler.config.marker);
                if(showFlg){
                    var tmpMediaTarget = trigger.data(MediaModalHandler.config.key);
                    var specialImg = trigger.data(MediaModalHandler.config.exceptionKey);
                    switch(tmpMediaTarget){
                        case 'img':
                            MediaModalHandler.config.viewContent.addClass(MediaModalHandler.config.marker);
                            if(specialImg != null){
                                MediaModalHandler.handler.adaptContent(
                                    '<img src="' + specialImg + '" style="width:50%; display:inline-block;">' + '<img src="' + trigger.find(tmpMediaTarget).attr('src') + '" style="width:50%; display:inline-block;">'
                                );
                            }else{
                                MediaModalHandler.handler.adaptContent('<img src="' + trigger.find(tmpMediaTarget).attr('src') + '">');
                            }
                            break;
                        case 'irregular':
                            var imgs = trigger.find('img');
                            var irregularW = null;
                            var irregularH = '600px';
                            if(DeviceHandler.config.cache.spDeviceFlg){
                                irregularW = 'auto';
                                irregularH = 'auto';
                            }
                            if(imgs.size() > 2){
                                if(!DeviceHandler.config.cache.spDeviceFlg){
                                    irregularW = '800px';
                                }
                                MediaModalHandler.handler.adaptContent(
                                    '<div style="width:' + irregularW + '; height:' + irregularH + '; background-color:#fff;">' +
                                        '<table>' +
                                            '<tr>' +
                                                '<td>' +
                                                    '<img src="images/content/2/duratect/2_1.png" alt="">' +
                                                '</td>' +
                                                '<td>' +
                                                    '<img src="images/content/2/duratect/4_1.png" alt="">' +
                                                '</td>' +
                                                '<td>' +
                                                    '<img src="images/content/2/duratect/4_2.png" alt="">' +
                                                '</td>' +
                                            '</tr>' +
                                            '<tr>' +
                                                '<td>Stainless steel</td>' +
                                                '<td colspan="2">Duratect GOLD</td>' +
                                            '</tr>' +
                                            '<tr>' +
                                                '<td></td>' +
                                                '<td>Yellow plating</td>' +
                                                '<td>Pink plating</td>' +
                                            '</tr>' +
                                        '</table>' +
                                        '<p class="txt">Scratch testing using internal testing equipment<br /><span>(Conditions: 5 passes of a sand eraser at 2kg pressure)</span></p>' +
                                    '</div>'
                                );
                            }else{
                                if(!DeviceHandler.config.cache.spDeviceFlg){
                                    irregularW = '600px';
                                }
                                MediaModalHandler.handler.adaptContent(
                                    '<div style="width:' + irregularW + '; height:' + irregularH + '; background-color:#fff;">' +
                                        '<ul>' +
                                            trigger.find('ul').html() +
                                        '</ul>' +
                                        '<p class="txt">Scratch testing using internal testing equipment<br /><span>(Conditions: 5 passes of a sand eraser at 2kg pressure)</span></p>' +
                                    '</div>'
                                );
                            }
                            break;
                        default :
                            var movieW = 900;
                            var movieH = 506;
                            if(DeviceHandler.config.cache.spDeviceFlg){
                                movieW = 300;
                                movieH = 180;
                            }
                            MediaModalHandler.handler.adaptContent('<iframe width="' + movieW +'" height="' + movieH + '" src="' + tmpMediaTarget + '" frameborder="0" allowfullscreen></iframe>');
                            break;
                    }
                    MediaModalHandler.config.root
                        .css('display', 'block')
                        .velocity('stop')
                        .velocity(
                            {
                                'opacity' : 1
                            },
                            {
                                'duration' : MediaModalHandler.config.interval.open,
                                'complete' : function(){
                                    BodyScrollHandler.config.forcedStopFlg = true;
                                }
                            }
                        );
                }else{
                    MediaModalHandler.config.root
                        .velocity('stop')
                        .velocity(
                            {
                                'opacity' : 0
                            },
                            {
                                'duration' : MediaModalHandler.config.interval.close,
                                'complete' : function(){
                                    $(this).css('display', 'none');
                                    MediaModalHandler.handler.adaptContent('');
                                    BodyScrollHandler.config.forcedStopFlg = false;
                                }
                            }
                        );
                }
            }
        },
        resize : function(){
            MediaModalHandler.config.content.css('height', COMMON.cache._w.height() + 'px');
        },
        bind : function(){
            MediaModalHandler.config.openModal.on('click', function(evt){
                MediaModalHandler.handler.display($(this), true);
                evt.preventDefault();
                evt.stopPropagation();
            });
            MediaModalHandler.config.closeModal.on('click', function(evt){
                MediaModalHandler.handler.display(null, false);
                evt.preventDefault();
                evt.stopPropagation();
            });
        },
        init : function(){
            MediaModalHandler.config.content = MediaModalHandler.config.root.find('.tableLayout');
            MediaModalHandler.resize();
            MediaModalHandler.bind();
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Label Image Height
    // -------------------------------------------------------------------------------------------------------
    var LabelImageHeightHandler = {
        config : {
            fullW : 1400,
            spFullW : 640,
            defaultH : 479,
            spDefaultH : 200,
            targets : $('.labelImg')
        },
        resize : function(){
            var fixedH = 0;
            if(DeviceHandler.config.cache.spDeviceFlg){
                fixedH = LabelImageHeightHandler.config.spDefaultH * (COMMON.cache._w.width() / LabelImageHeightHandler.config.spFullW);
            }else{
                fixedH = LabelImageHeightHandler.config.defaultH * (COMMON.cache._w.width() / LabelImageHeightHandler.config.fullW);
            }
            LabelImageHeightHandler.config.targets.each(function(){
                $(this).css('height', fixedH + 'px');
            });
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Main Content View
    // -------------------------------------------------------------------------------------------------------
    var MainContentViewHandler = {
        config : {
            key : {
                'contentIdx' : 'idx-content',
                'originalH' : 'original-h',
                'triggerH' : 'trigger-h',
                'triggerSpH' : 'trigger-sp-h',
                'originalTxt' : 'original-txt',
                'openedTxt' : 'opened-txt'
            },
            marker : '___opened',
            triggers : $('.contentSubTrigger'),
            triggersBg : null,
            visibleArea : null,
            interval : 1000
        },
        handler : {
            refinePosition : function(pos, callBack){
                COMMON.cache._r.velocity(
                    'scroll',
                    {
                        'begin' : function(){
                            BodyScrollHandler.config.forcedStopFlg = true;
                        },
                        'duration' : 500,
                        'offset' : pos + 'px',
                        'complete' : function(){
                            if(callBack){
                                callBack();
                            }
                            BodyScrollHandler.config.forcedStopFlg = false;
                        }
                    }
                );
            },
            parseIdx : function(rowData){
                var tmpIdxInfo = rowData.split('-');
                return MainContentViewHandler.config.visibleArea[parseInt(tmpIdxInfo[0], 10) - 1][parseInt(tmpIdxInfo[1], 10) - 1];
            },
            display : function(trigger, target, originalH, triggerH, triggerSpH, originalTxt, openedTxt){
                var tmpTriggerStr = trigger.find('.bgTxt');
                if(triggerH != 0){
                    tmpTriggerStr.css('opacity', 0);
                }
                if(target.hasClass(MainContentViewHandler.config.marker)){
                    trigger.removeClass(MainContentViewHandler.config.marker);
                    target
                        .removeClass(MainContentViewHandler.config.marker)
                        .slideUp('slow', function(){
                            if(triggerH != 0){
                                tmpTriggerStr.html(originalTxt.replace('\\n', '<br />'));
                                if(DeviceHandler.config.cache.spDeviceFlg){
                                    trigger.find('.bg').css('height', 50 + 'px');
                                    tmpTriggerStr
                                        .velocity(
                                            {
                                                'opacity' : 1
                                            },
                                            {
                                                'easing' : 'ease-in-out',
                                                'delay' : MainContentViewHandler.config.interval / 2,
                                                'duration' : MainContentViewHandler.config.interval
                                            }
                                        );
                                }else{
                                    trigger.find('.bg').velocity(
                                        {
                                            'height' : triggerH + 'px'
                                        },
                                        {
                                            'easing' : 'ease-in-out',
                                            'complete' : function(){
                                                tmpTriggerStr
                                                    .velocity(
                                                        {
                                                            'opacity' : 1
                                                        },
                                                        {
                                                            'delay' : MainContentViewHandler.config.interval / 2,
                                                            'duration' : MainContentViewHandler.config.interval
                                                        }
                                                    )
                                            }
                                        }
                                    );
                                }
                            }
                        });
                }else{
                    trigger.addClass(MainContentViewHandler.config.marker);
                    target
                        .addClass(MainContentViewHandler.config.marker)
                        .css(
                            {
                                'opacity' : '0',
                                'display' : 'block'
                            }
                        );
                    if(originalH != 0){
                        tmpTriggerStr.html(openedTxt.replace('\\n', '<br />'));
                        if(DeviceHandler.config.cache.spDeviceFlg){
                            MainContentViewHandler.handler.refinePosition(
                                trigger.offset().top - MainViewHandler.config.cache.spHeaderH,
                                function(){
                                    trigger.find('.bg')
                                        .velocity(
                                            {
                                                'height' : (triggerSpH * (COMMON.cache._w.width() / 640)) + 'px'
                                            },
                                            {
                                                'easing' : 'ease-in-out',
                                                'duration' : 500,
                                                'complete' : function(){
                                                    tmpTriggerStr
                                                        .velocity(
                                                            {
                                                                'opacity' : 1
                                                            },
                                                            {
                                                                'duration' : MainContentViewHandler.config.interval / 2,
                                                                'complete' : function(){}
                                                            }
                                                        );
                                                    target.velocity(
                                                        {
                                                            'opacity' : 1
                                                        },
                                                        {
                                                            'duration' : MainContentViewHandler.config.interval / 2
                                                        }
                                                    );
                                                }
                                            }
                                        );
                                }
                            );
                        }else{
                            MainContentViewHandler.handler.refinePosition(
                                trigger.offset().top,
                                function(){
                                    trigger.find('.bg').velocity(
                                        {
                                            'height' : (originalH * (COMMON.cache._w.width() / 1400)) + 'px'
                                        },
                                        {
                                            'easing' : 'ease-in-out',
                                            'complete' : function(){
                                                tmpTriggerStr
                                                    .velocity(
                                                        {
                                                            'opacity' : 1
                                                        },
                                                        {
                                                            'delay' : MainContentViewHandler.config.interval / 2,
                                                            'duration' : MainContentViewHandler.config.interval
                                                        }
                                                    );
                                                target.velocity(
                                                    {
                                                        'opacity' : 1
                                                    },
                                                    {
                                                        'duration' : 800
                                                    }
                                                );
                                            }
                                        }
                                    );
                                }
                            );
                        }
                    }else{
                        MainContentViewHandler.handler.refinePosition(
                            DeviceHandler.config.cache.spDeviceFlg ? trigger.offset().top - MainViewHandler.config.cache.spHeaderH : trigger.offset().top,
                            function(){
                                target.velocity(
                                    {
                                        'opacity' : 1
                                    },
                                    {
                                        'duration' : 800
                                    }
                                );
                            }
                        );
                    }
                }
            }
        },
        bind : function(){
            MainContentViewHandler.config.triggers.each(function(){
                $(this).on('click', function(){
                    MainContentViewHandler.handler.display(
                        $(this),
                        MainContentViewHandler.handler.parseIdx(
                            $(this).data(MainContentViewHandler.config.key['contentIdx'])
                        ),
                        $(this).data(MainContentViewHandler.config.key['originalH']) || 0,
                        $(this).data(MainContentViewHandler.config.key['triggerH']) || 0,
                        $(this).data(MainContentViewHandler.config.key['triggerSpH']),
                        $(this).data(MainContentViewHandler.config.key['originalTxt']),
                        $(this).data(MainContentViewHandler.config.key['openedTxt'])
                    );
                });
            })
        },
        resize : function(){
            MainContentViewHandler.config.triggers.each(function(){
                var tmpHeight = undefined;
                if(DeviceHandler.config.cache.spDeviceFlg){
                    if($(this).hasClass(MainContentViewHandler.config.marker)){
                        tmpHeight = $(this).data(MainContentViewHandler.config.key['triggerSpH']);
                        tmpHeight = tmpHeight * (COMMON.cache._w.width() / 640);
                    }else{
                        tmpHeight = 50;
                    }
                }else{
                    if($(this).hasClass(MainContentViewHandler.config.marker)){
                        tmpHeight = $(this).data(MainContentViewHandler.config.key['originalH']);
                    }else{
                        tmpHeight = $(this).data(MainContentViewHandler.config.key['triggerH']);
                    }
                    tmpHeight = tmpHeight * (COMMON.cache._w.width() / 1400);
                }
                if(tmpHeight !== undefined && !isNaN(tmpHeight)){
                    $(this).find('.bg').css(
                        'height',
                        tmpHeight + 'px'
                    );
                }else{
                    if(DeviceHandler.config.cache.spDeviceFlg){
                        $(this).find('.bg').css('height','50px');
                    }else{
                        $(this).find('.bg').css('height','145px');
                    }
                }
            });
        },
        init : function(){
            MainContentViewHandler.config.visibleArea = [];
            var tmpVisibleAreaCache = null;
            for(var i = 1; i <= MainViewHandler.config.num; i++){
                tmpVisibleAreaCache = [];
                 $('[id^="subViewWrapper' + i + '_"]').each(function(){
                    tmpVisibleAreaCache.push($(this));
                 });
                 MainContentViewHandler.config.visibleArea.push(tmpVisibleAreaCache);
            }
            MainContentViewHandler.bind();
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // For Dummy Scroll
    // -------------------------------------------------------------------------------------------------------
    var DummyScrollHandler = {
        config : {
            cache : 0,
            rate : 100,
            buffer : {
                bottom : 40
            },
            root : $('#modalContent'),
            content : $('#modalWrapper')
        },
        handler : {
            down : function(){
                DummyScrollHandler.config.cache += DummyScrollHandler.config.rate;
                if(DummyScrollHandler.config.cache > 0){
                    DummyScrollHandler.config.cache = 0;
                }
                DummyScrollHandler.handler.update(DummyScrollHandler.config.cache);
            },
            up : function(){
                if(Math.abs(DummyScrollHandler.config.cache) + COMMON.cache._w.height() < DummyScrollHandler.config.content.outerHeight() + DummyScrollHandler.config.buffer.bottom){
                    DummyScrollHandler.config.cache -= DummyScrollHandler.config.rate;
                    DummyScrollHandler.handler.update(DummyScrollHandler.config.cache);
                }
            },
            update : function(cache){
                DummyScrollHandler.config.content
                    .velocity('stop')
                    .velocity(
                        {
                            'translateY' : cache + 'px'
                        },
                        {
                            'duration' : 250,
                             'easing' : 'ease-in-out',
                            'complete' : function(){}
                        }
                    );
            },
            reset : function(){
                DummyScrollHandler.config.cache = 0;
                DummyScrollHandler.config.content
                    .velocity(
                        {
                            'translateY' : DummyScrollHandler.config.cache + 'px'
                        },
                        {
                            'duration' : 10,
                            'complete' : function(){}
                        }
                    );
            }
        },
        init : function(){
            DummyScrollHandler.config.root.touchwipe(
                {
                    wipeLeft : function(){},
                    wipeRight : function(){},
                    wipeUp : function(){
                        DummyScrollHandler.handler.down();
                    },
                    wipeDown : function(){
                        DummyScrollHandler.handler.up();
                    },
                    min_move_x: 50,
                    min_move_y: 50,
                    preventDefaultEvents: true
                }
            );
        }
    };
    // -------------------------------------------------------------------------------------------------------
    // INIT
    // -------------------------------------------------------------------------------------------------------
    COMMON.init();
    DeviceHandler.bind();
    HeaderMenuHandler.init();
    MainViewHandler.init();
    ModalHandler.resize(DeviceHandler.config.cache.spDeviceFlg);
    ModalHandler.bind();
    TabContentHandler.init();
    MainContentViewHandler.init();
    LabelImageHeightHandler.resize();
    BodyScrollHandler.watch();
    BodyScrollHandler.bind(0);
    MediaModalHandler.init();
    HashController.init(
        {
            noHashCallBack : function(){
                MainViewHandler.reset(0, false, true);
            },
            hashCallBack : function(hash){
                ModalHandler.handler.display(false, DeviceHandler.config.cache.spDeviceFlg);
                HeaderMenuHandler.config.root.removeClass(HeaderMenuHandler.config.marker);
                hashMovedStatus = false;
                switch(hash){
                    case '#top' :
                        MainViewHandler.reset(0, false, true);
                        setTimeout(function(){
                            HeaderMenuHandler.config.root.removeClass(HeaderMenuHandler.config.marker);
                        }, 800);
                        break;
                    case '#eco-drive' :
                        if(COMMON.cache._b.hasClass(movedMarker)){
                            MainViewHandler.show(1, true, false);
                        }else{
                            MainViewHandler.reset(1, false, true);
                        }
                        break;
                    case '#super-titanium' :
                        if(COMMON.cache._b.hasClass(movedMarker)){
                            MainViewHandler.show(2, true, false);
                        }else{
                            MainViewHandler.reset(2, false, true);
                        }
                        break;
                    //case '#satellite_radio-clock' :
                    case '#satellite_radio-controlled' :
                        if(COMMON.cache._b.hasClass(movedMarker)){
                            MainViewHandler.show(3, true, false);
                        }else{
                            MainViewHandler.reset(3, false, true);
                        }
                        break;
                    case '#abcd':
                        if(COMMON.cache._b.hasClass(movedMarker)){
                            MainViewHandler.show(3, true, false);
                        }else{
                            MainViewHandler.reset(3, false, true);
                            setTimeout(function(){
                                TabContentHandler.handler.display(null, 1);
                            }, 10);

                        }
                        break;
                }
            }
        },
        true
    );
    // -------------------------------------------------------------------------------------------------------
    // For IE8
    // -------------------------------------------------------------------------------------------------------
    if(COMMON.config.browser.name == 'IE8'){
        $('.mvPart').css(
            {
                backgroundSize : 'cover'
            }
        );
        $('.bg').css(
            {
                backgroundSize: 'cover'
            }
        );
    }
    // -------------------------------------------------------------------------------------------------------
    // For Cell Phone
    // -------------------------------------------------------------------------------------------------------
    DummyScrollHandler.init();
    // -------------------------------------------------------------------------------------------------------
    // RESIZE
    // -------------------------------------------------------------------------------------------------------
    COMMON.cache._w.on('resize', function(){
        DeviceHandler.bind();
        MainViewHandler.resize(DeviceHandler.config.cache.spDeviceFlg);
        ModalHandler.resize(DeviceHandler.config.cache.spDeviceFlg);
        MainContentViewHandler.resize();
        LabelImageHeightHandler.resize();
    });
    // -------------------------------------------------------------------------------------------------------
    // BEFORE UNLOAD
    // -------------------------------------------------------------------------------------------------------
    COMMON.cache._w.on('beforeunload', function(){
        BodyScrollHandler.refineZero();
        COMMON.cache._b.removeClass(movedMarker);
    });
    // -------------------------------------------------------------------------------------------------------
    // TO TOP
    // -------------------------------------------------------------------------------------------------------
    $('.toTopWrapper a').each(function(){
        $(this).click(function(){
            COMMON.cache._r.velocity(
                'scroll',
                {
                    'begin' : function(){
                        BodyScrollHandler.config.forcedStopFlg = true;
                    },
                    'duration' : 500,
                    'offset' : '0px',
                    'complete' : function(){
                        BodyScrollHandler.config.forcedStopFlg = false;
                    }
                }
            );
        })
    });
    ModalHandler.handler.display(true, DeviceHandler.config.cache.spDeviceFlg);
});