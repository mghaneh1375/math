<!doctype html>
<html class="no-js" lang="en">

<head>

    @section('header')
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>پنل ادمین</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('asset/img/logo.png') }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="{{ asset('admin-panel/js/jquery.min.js') }}"></script>
        <!-- Google Fonts
                                                                                                                        ============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i,800" rel="stylesheet">
        <!-- Bootstrap CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/bootstrap.min.css') }}">
        <!-- Bootstrap CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/font-awesome.min.css') }}">

        <!-- adminpro icon CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/adminpro-custon-icon.css') }}">

        <!-- meanmenu icon CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/meanmenu.min.css') }}">

        <!-- mCustomScrollbar CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/jquery.mCustomScrollbar.min.css') }}">

        <!-- animate CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/modal.css') }}">

        <!-- normalize CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/data-table/bootstrap-editable.css') }}">

        <link rel="stylesheet" href="{{ asset('admin-panel/css/accordions.css') }}">

        <!-- normalize CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/normalize.css') }}">
        <!-- charts CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/tabs.css') }}">
        <!-- style CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/style.css') }}">
        <!-- responsive CSS
                                                                                                                        ============================================ -->
        <link rel="stylesheet" href="{{ asset('admin-panel/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/common.css?v=1.2') }}">
        <link rel="stylesheet" href="{{ asset('admin-panel/css/commonCSS.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/fonts/font.css') }}" />

        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <!-- modernizr JS
                                                                                                                        ============================================ -->
        <script src="{{ asset('admin-panel/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        <link href="{{ asset('admin-panel/css/iziToast.min.css') }}" rel="stylesheet" />

        <script>
            function validateNumber(evt) {
                var theEvent = evt || window.event;

                // Handle paste
                if (theEvent.type === 'paste') {
                    key = event.clipboardData.getData('text/plain');
                } else {
                    // Handle key press
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                }
                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }
            }
        </script>
    @show

</head>

<body class="darklayout">

    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- Header top area start-->
    <div class="wrapper-pro">
        <div class="left-sidebar-pro">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <a
                        href="{{ route('admin_dashboard') }}">
                    </a>
                    <h3>پنل ادمین</h3>
                </div>
                <div class="left-custom-menu-adp-wrap">
                    @if (Auth::check())
                        <ul class="nav navbar-nav left-sidebar-menu-pro">
                        
                            <li class="nav-item"><a href="{{ route('course.index') }}" role="button"
                                    class="nav-link"><i></i> <span class="mini-dn">مدیریت دوره‌ها</span></a></li>

                            <li class="nav-item">
                                <a data-toggle="dropdown" role="button" aria-expanded="false"
                                    class="nav-link dropdown-toggle">
                                    <i></i> 
                                    <span class="mini-dn">تنظیمات</span> 
                                    <span class="indicator-right-menu mini-dn">
                                        <i class="fa indicator-mn fa-angle-left"></i>
                                    </span>
                                </a>
                                <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                    <a href="{{ route('public_seo_tags.index') }}" class="dropdown-item">تگ‌های سئو عمومی</a>
                                    <a href="{{ route('config.index') }}" class="dropdown-item">تنظیمات عمومی</a>
                                </div>
                            </li>

                            {{-- <li class="nav-item">
                                <a data-toggle="dropdown" role="button" aria-expanded="false"
                                    class="nav-link dropdown-toggle">
                                    <i></i> 
                                    <span class="mini-dn">کاربران</span> 
                                    <span class="indicator-right-menu mini-dn">
                                        <i class="fa indicator-mn fa-angle-left"></i>
                                    </span>
                                </a>
                                <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                    <a href="{{ route('mentors.index') }}" class="dropdown-item">مربیان</a>
                                    <a href="{{ route('schools.index') }}" class="dropdown-item">مدارس</a>
                                    <a href="{{ route('reporters.index') }}" class="dropdown-item">گزارشگیران</a>
                                    <a href="{{ route('user.index') }}" class="dropdown-item">لیست تمام کاربران</a>
                                </div>
                            </li> --}}

                            {{-- <li class="nav-item"><a href="{{ route('ticket.index') }}" role="button"
                                    class="nav-link"><i></i> <span class="mini-dn">تیکت ها</span></a></li> --}}

                            {{-- <li class="nav-item"><a href="{{ route('changePassword') }}" role="button"
                                    class="nav-link"><i></i> <span class="mini-dn">تغییر رمزعبور</span></a></li> --}}

                            <li class="nav-item">
                                <a data-toggle="dropdown" role="button" aria-expanded="false"
                                    class="nav-link dropdown-toggle">
                                    <i></i> 
                                    <span class="mini-dn">کدهای تخفیف</span> 
                                    <span class="indicator-right-menu mini-dn">
                                        <i class="fa indicator-mn fa-angle-left"></i>
                                    </span>
                                </a>
                                <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                    <a href="{{ route('offer.index') }}" class="dropdown-item">لیست کدها</a>
                                    <a href="{{ route('offer.create') }}" class="dropdown-item">ایجاد کد تخفیف جدید</a>
                                </div>
                            </li>

                            <li class="nav-item"><a href="{{ route('logout') }}" role="button"
                                    class="nav-link"><i></i> <span class="mini-dn">خروج</span></a></li>
                        </ul>
                    @endif
                </div>
            </nav>
        </div>

        <div class="content-inner-all-fa">
            @yield('content')
        </div>

        <div id="myModal"
            class="modal hidden modal-adminpro-general fullwidth-popup-InformationproModal fade bounceInDown animated in">
            <div class="modal-content">
                <input type="hidden" value="" id="slideId" name="id">
                <input type="hidden" value="delete" name="kind">
                <h2 style="padding-right: 5%;">ایا اطیمنان دارید؟</h2>
                <div class="flex center gap10">
                    <input type="submit" value="بله" class="btn green"
                        style="margin-right: 5px; margin-bottom: 3%" onclick="remove()">
                    <input type="button" value="انصراف" class="btn green"
                        style="margin-bottom: 3%; margin-left: 5px;" onclick="$('#myModal').addClass('hidden')">
                </div>
            </div>
        </div>

        @section('reminder')
            <!-- jquery
                                                                                                                    ============================================ -->
            <script src="{{ asset('admin-panel/js/vendor/jquery-1.11.3.min.js') }}"></script>
            <!-- bootstrap JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/bootstrap.min.js') }}"></script>
            <!-- meanmenu JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.meanmenu.js') }}"></script>
            <!-- mCustomScrollbar JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
            <!-- sticky JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.sticky.js') }}"></script>
            <!-- scrollUp JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/jquery.scrollUp.min.js') }}"></script>
            <!-- scrollUp JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/wow/wow.min.js') }}"></script>
            <!-- counterup JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/counterup/jquery.counterup.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/counterup/waypoints.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/counterup/counterup-active.js') }}"></script>
            <!-- jvectormap JS
                                                                                                                            ============================================ -->
            {{-- <script src="{{asset('admin-panel/js/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script> --}}
            {{-- <script src="{{asset('admin-panel/js/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
            {{-- <script src="{{asset('admin-panel/js/jvectormap/jvectormap-active.js')}}"></script> --}}
            <!-- peity JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/peity/jquery.peity.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/peity/peity-active.js') }}"></script>
            <!-- sparkline JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/sparkline/jquery.sparkline.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/sparkline/sparkline-active.js') }}"></script>
            <!-- data table JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/tableExport.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/data-table-active.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table-editable.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-editable.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table-resizable.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/colResizable-1.5.source.js') }}"></script>
            <script src="{{ asset('admin-panel/js/data-table/bootstrap-table-export.js') }}"></script>

            <script src="{{ asset('admin-panel/js/dropzone.js') }}"></script>
            <script src="{{ asset('admin-panel/js/multiple-email-active.js') }}"></script>
            <script src="{{ asset('admin-panel/js/summernote.min.js') }}"></script>
            <script src="{{ asset('admin-panel/js/summernote-active.js') }}"></script>

            <!-- main JS
                                                                                                                            ============================================ -->
            <script src="{{ asset('admin-panel/js/main.js') }}"></script>
            <script src="{{ asset('admin-panel/js/iziToast.min.js') }}"></script>

            <script type="text/javascript">
                function showErr(msg) {
                    s = {
                        rtl: true,
                        class: "iziToast-" + "danger",
                        title: "ناموفق",
                        message: msg,
                        animateInside: !1,
                        position: "topRight",
                        progressBar: !1,
                        icon: 'ri-close-fill',
                        timeout: 3200,
                        transitionIn: "fadeInLeft",
                        transitionOut: "fadeOut",
                        transitionInMobile: "fadeIn",
                        transitionOutMobile: "fadeOut",
                        color: "red",
                    };
                    iziToast.show(s);
                }

                function showSuccess(msg) {
                    s = {
                        rtl: true,
                        class: "iziToast-" + "danger",
                        title: "موفق!",
                        message: msg,
                        animateInside: !1,
                        position: "topRight",
                        progressBar: !1,
                        icon: 'ri-check-fill',
                        timeout: 3200,
                        transitionIn: "fadeInLeft",
                        transitionOut: "fadeOut",
                        transitionInMobile: "fadeIn",
                        transitionOutMobile: "fadeOut",
                        color: "green",
                        type: 'success'
                    };
                    iziToast.show(s);
                }


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        if(XMLHttpRequest.status === 409) {
                            showErr(XMLHttpRequest.responseJSON.message);
                            $("#myModal").addClass('hidden');
                            return;
                        }
                        var errs = JSON.parse(XMLHttpRequest.responseText).errors;

                        if (errs instanceof Object) {
                            var errsText = '';

                            Object.keys(errs).forEach(function(key) {
                                errsText += errs[key] + "<br />";
                            });

                            showErr(errsText);
                        } else {
                            var errsText = '';

                            for (let i = 0; i < errs.length; i++)
                                errsText += errs[i].value;

                            showErr(errsText);
                        }
                    }
                });

                function isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }

                function isEN(evt) {
                    // return /^[a-zA-Z]+$/.test(evt.);
                }

                let removeURL;
                let itemID;
                let item;

                function removeModal(node, id, url, ) {
                    $("#myModal").removeClass('hidden');
                    removeURL = url;
                    itemID = id;
                    item = node;
                }

                function remove() {

                    $.ajax({
                        type: 'delete',
                        url: removeURL,
                        headers: {
                            "Accept": "application/json"
                        },
                        success: function(res) {
                            $("#myModal").addClass('hidden');
                            $("#" + item + "_" + itemID).remove();
                            showSuccess("عملیات موردنظر با موفقیت انجام شد.");
                        }
                    })

                }
            </script>

        @show
    </div>
</body>
