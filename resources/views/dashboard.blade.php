<x-app-layout>
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-header-actions position-relative border rounded-3 p-4 mb-6">
                        <div class="row align-items-center" style="z-index: 2;">
                            <!-- Greeting Section - Left Side -->
                            <div class="col-md-9 col-12">
                            <div class="greeting-section animate-rise my-6">
                                    <h1 class="font-weight-bold mb-0">Hello, {{ Auth::user()->name ?? 'Student' }}</h1>
                                    <h3 class="font-weight-bold mb-0">Welcome to your GISO 360 Dashboard!</h3>
                                </div>
                            </div>
                        </div>
                        <div class="image-container animate-rise-delay me-5 mr-5">
                            <img src="{{ asset('assets/img/travel header 2.png') }}" 
                                alt="Travel Header" 
                                class="header-image img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <style>
            .dashboard-header-actions {
                background: rgba(255, 255, 255, 0.18);
                border-radius: 16px;
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                backdrop-filter: blur(6.3px);
                -webkit-backdrop-filter: blur(6.3px);
                border: 1px solid rgba(255, 255, 255, 0.3); /* Slightly adjusted from pure white for subtlety */
                transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                position: relative;
                overflow: hidden;
            }

            /* Add subtle highlight effect */
            .dashboard-header-actions::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 1px;
                background: linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.5) 50%,
                    rgba(255, 255, 255, 0) 100%
                );
                z-index: 1;
            }

            .dashboard-header-actions:hover {
                background: rgba(255, 255, 255, 0.25);
                box-shadow: 0 8px 40px rgba(0, 0, 0, 0.15);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.4);
                transform: translateY(-2px) scale(1.005);
            }

            /* Add a subtle colored tint */
            .dashboard-header-actions::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(
                    135deg, 
                    rgba(59, 130, 246, 0.03) 0%, 
                    rgba(168, 85, 247, 0.03) 100%
                );
                z-index: -1;
                border-radius: inherit;
                opacity: 0;
                transition: opacity 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }

            .dashboard-header-actions:hover::after {
                opacity: 1;
            }

            /* Add a subtle inner shadow for depth */
            .dashboard-header-actions:active {
                transform: translateY(0) scale(0.998);
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
                background: rgba(255, 255, 255, 0.22);
            }

                .dashboard-header-actions:hover {
                    background: rgba(255, 255, 255, 0.78);
                    backdrop-filter: blur(25px) saturate(190%);
                    -webkit-backdrop-filter: blur(25px) saturate(190%);
                    box-shadow: 
                        0 12px 40px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.95),
                        inset 0 -1px 0 rgba(255, 255, 255, 0.3);
                    transform: translateY(-2px) scale(1.005);
                }

                /* Add a more subtle colored tint */
                .dashboard-header-actions::after {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: linear-gradient(
                        135deg, 
                        rgba(59, 130, 246, 0.03) 0%, 
                        rgba(168, 85, 247, 0.03) 100%
                    );
                    z-index: -1;
                    border-radius: inherit;
                    opacity: 0;
                    transition: opacity 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                }

                .dashboard-header-actions:hover::after {
                    opacity: 1;
                }

                /* Add a subtle inner shadow for depth */
                .dashboard-header-actions:active {
                    transform: translateY(0) scale(0.998);
                    box-shadow: 
                        0 5px 20px rgba(0, 0, 0, 0.1),
                        inset 0 1px 2px rgba(0, 0, 0, 0.08),
                        inset 0 -1px 0 rgba(255, 255, 255, 0.3);
                }
                
                .image-container {
                    position: absolute;
                    top: -50px; /* Reduced from -50px */
                    right: -30px; /* Reduced from -30px */
                    z-index: 1;
                    max-width: 60%; /* Reduced from 60% */
                }

                .header-image {
                    width: 100%;
                    height: auto;
                    max-height: 400px; /* Reduced from 400px */
                    object-fit: cover;
                    border-radius: 20px; /* Reduced from 20px */
                    transition: transform 0.3s ease;
                }
                
                /* Rise Animation */
                .animate-rise {
                    opacity: 0;
                    transform: translateY(30px);
                    animation: rise 0.8s ease forwards;
                }
                
                .animate-rise-delay {
                    opacity: 0;
                    transform: translateY(30px);
                    animation: rise 0.8s ease 0.3s forwards;
                }
                
                @keyframes rise {
                    0% {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    100% {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                /* Add text shadow for better readability */
                .greeting-section h3,
                .greeting-section p {
                    text-shadow: 0 2px 4px rgba(255, 255, 255, 0.8);
                }
                
            </style>
        </div>
        



        <!-- News Section Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div>
                        <h3 class="font-weight-bold mb-0">What is on the news today?</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Swiper -->

            
            <!-- Your specified CSS files -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
            <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
            <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
            <link id="pagestyle" href="{{ asset('assets/css/corporate-ui-dashboard.css?v=1.0.0') }}" rel="stylesheet" />
            
            <!-- Font Awesome -->
            <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
            
            <!-- Bootstrap CSS (still needed for carousel) -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
            
            <style>
                /* Custom styles using your theme */
                .carousel-container {
                    max-width: 900px;
                    margin: 40px auto;
                    position: relative;
                }

                .news-carousel {
                    border-radius: 12px;
                    overflow: hidden;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                    transition: all 0.3s ease;
                    cursor: pointer;
                }

                .news-carousel:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
                }

                /* Fixed image size for all slides */
                .carousel-image-container {
                    width: 100%;
                    height: 350px;
                    overflow: hidden;
                    position: relative;
                }

                .carousel-image-container img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: center;
                    transition: transform 0.5s ease;
                }

                .carousel-item:hover .carousel-image-container img {
                    transform: scale(1.05);
                }

                /* Caption styling */
                .carousel-caption-custom {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    padding: 30px 25px 20px;
                    background: linear-gradient(transparent, rgba(0, 0, 0, 0.85));
                    color: white;
                    text-align: left;
                    z-index: 2;
                }

                .carousel-caption-custom h4 {
                    font-family: 'Noto Sans', sans-serif;
                    font-weight: 700;
                    font-size: 1.4rem;
                    margin-bottom: 8px;
                    color: #fff;
                }

                .carousel-caption-custom h5 {
                    font-family: 'Open Sans', sans-serif;
                    font-weight: 400;
                    font-size: 0.95rem;
                    margin-bottom: 0;
                    opacity: 0.9;
                    color: #f0f0f0;
                }

                /* Indicators */
                .carousel-indicators-custom {
                    position: absolute;
                    bottom: 15px;
                    left: 0;
                    right: 0;
                    display: flex;
                    justify-content: center;
                    padding: 0;
                    margin: 0;
                    list-style: none;
                    z-index: 3;
                }

                .carousel-indicators-custom li {
                    width: 10px;
                    height: 10px;
                    margin: 0 6px;
                    background-color: rgba(255, 255, 255, 0.5);
                    border-radius: 50%;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    border: none;
                }

                .carousel-indicators-custom li.active {
                    background-color: #fff;
                    transform: scale(1.3);
                    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
                }

                /* Navigation controls */
                .carousel-control-custom {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    width: 45px;
                    height: 45px;
                    background: rgba(0, 0, 0, 0.6);
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    opacity: 0;
                    transition: all 0.3s ease;
                    z-index: 3;
                    cursor: pointer;
                }

                .news-carousel:hover .carousel-control-custom {
                    opacity: 1;
                }

                .carousel-control-custom:hover {
                    background: rgba(0, 0, 0, 0.8);
                }

                .carousel-control-prev-custom {
                    left: 20px;
                }

                .carousel-control-next-custom {
                    right: 20px;
                }

                .carousel-control-custom i {
                    color: white;
                    font-size: 20px;
                }

                /* Slide number indicator */
                .slide-counter {
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    background: rgba(0, 0, 0, 0.6);
                    color: white;
                    padding: 5px 12px;
                    border-radius: 20px;
                    font-family: 'PT Mono', monospace;
                    font-size: 0.8rem;
                    z-index: 3;
                }

                /* Responsive adjustments */
                @media (max-width: 992px) {
                    .carousel-container {
                        max-width: 95%;
                    }
                    
                    .carousel-image-container {
                        height: 300px;
                    }
                }

                @media (max-width: 768px) {
                    .carousel-image-container {
                        height: 250px;
                    }
                    
                    .carousel-caption-custom {
                        padding: 20px 15px 15px;
                    }
                    
                    .carousel-caption-custom h4 {
                        font-size: 1.2rem;
                    }
                    
                    .carousel-caption-custom h5 {
                        font-size: 0.85rem;
                    }
                    
                    .carousel-control-custom {
                        width: 40px;
                        height: 40px;
                        opacity: 0.7;
                    }
                }

                @media (max-width: 576px) {
                    .carousel-image-container {
                        height: 220px;
                    }
                    
                    .carousel-caption-custom h4 {
                        font-size: 1.1rem;
                    }
                    
                    .carousel-caption-custom h5 {
                        font-size: 0.8rem;
                    }
                    
                    .carousel-control-custom {
                        width: 35px;
                        height: 35px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container-fluid px-3 px-md-5 mb-5">
                <div class="carousel-container">
                    <div class="news-carousel" id="newsCarousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators-custom">
                            <li class="active" data-target="#newsCarousel" data-slide-to="0"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                            <li data-target="#newsCarousel" data-slide-to="3"></li>
                            <li data-target="#newsCarousel" data-slide-to="4"></li>
                            <li data-target="#newsCarousel" data-slide-to="5"></li>
                        </ol>

                        <!-- Carousel Items -->
                        <div class="carousel-inner">
                            <!-- News Item 1 -->
                            <div class="carousel-item active" onclick="window.open('https://www.usim.edu.my/news/giso-ayo-nang-indonesia-mahasiswa-usim-bina-ukhuwah-dan-inovasi-global/', '_blank')">
                                <div class="carousel-image-container">
                                    <img src="https://www.usim.edu.my/wp-content/uploads/2025/10/06_GISO-INDONESIA-UNIVERSITAS-SUNAN-KALIJAGA-YOGYAKARTA-Copy.jpg" alt="GISO AYO NANG INDONESIA">
                                </div>
                                <div class="carousel-caption-custom">
                                    <h4>#1 GISO AYO NANG INDONESIA</h4>
                                    <h5>Mahasiswa USIM Bina Ukhuwah dan Inovasi Global</h5>
                                </div>
                                <div class="slide-counter">1/6</div>
                            </div>
                            
                            <!-- News Item 2 -->
                            <div class="carousel-item" onclick="window.open('https://www.usim.edu.my/news/giso-melbourne-2025-mahasiswa-usim-mendalami-kehidupan-islam-minoriti-di-australia/', '_blank')">
                                <div class="carousel-image-container">
                                    <img src="https://www.usim.edu.my/wp-content/uploads/2025/08/WhatsApp-Image-2025-08-25-at-3.04.58-PM.jpeg" alt="GISO Melbourne">
                                </div>
                                <div class="carousel-caption-custom">
                                    <h4>#2 GISO Melbourne</h4>
                                    <h5>Mahasiswa USIM Mendalami Kehidupan Islam Minoriti di Australia</h5>
                                </div>
                                <div class="slide-counter">2/6</div>
                            </div>
                            
                            <!-- News Item 3 -->
                            <div class="carousel-item" onclick="window.open('https://www.usim.edu.my/news/pengembaraan-giso-usim-gps-perkukuh-jalinan-antarabangsa-di-universitas-muhammadiyah-makassar/', '_blank')">
                                <div class="carousel-image-container">
                                    <img src="https://www.usim.edu.my/wp-content/uploads/2024/09/IMG_9056-Copy.jpg" alt="GISO USIM GPS">
                                </div>
                                <div class="carousel-caption-custom">
                                    <h4>#3 GISO USIM GPS</h4>
                                    <h5>Pengembaraan GISO USIM GPS Perkukuh Jalinan Antarabangsa</h5>
                                </div>
                                <div class="slide-counter">3/6</div>
                            </div>
                            
                            <!-- News Item 4 -->
                            <div class="carousel-item" onclick="window.open('https://www.usim.edu.my/news/campus-news/giso-jalinan-kasih-bukit-tinggi-indonesia-membina-mahasiswa-usim-cakna-budaya-dan-budi/', '_blank')">
                                <div class="carousel-image-container">
                                    <img src="https://www.usim.edu.my/wp-content/uploads/2023/09/MG_6901-Copy.jpg" alt="GISO Bukit Tinggi Indonesia">
                                </div>
                                <div class="carousel-caption-custom">
                                    <h4>#4 GISO Bukit Tinggi Indonesia</h4>
                                    <h5>Jalinan Kasih Membina Mahasiswa USIM Cakna Budaya dan Budi</h5>
                                </div>
                                <div class="slide-counter">4/6</div>
                            </div>
                            
                            <!-- News Item 5 -->
                            <div class="carousel-item" onclick="window.open('https://www.usim.edu.my/news/giso-davao-dekati-perkampungan-komuniti-islam/', '_blank')">
                                <div class="carousel-image-container">
                                    <img src="https://www.usim.edu.my/wp-content/uploads/2020/02/82911298_774993989655121_1059695223652745216_o-e1580713775611.jpg" alt="GISO Davao">
                                </div>
                                <div class="carousel-caption-custom">
                                    <h4>#5 GISO Davao</h4>
                                    <h5>Dekati Perkampungan Komuniti Islam</h5>
                                </div>
                                <div class="slide-counter">5/6</div>
                            </div>
                            
                            <!-- News Item 6 -->
                            <div class="carousel-item" onclick="window.open('https://www.usim.edu.my/news/giso-syria-come-2-0-mission-accomplished/', '_blank')">
                                <div class="carousel-image-container">
                                    <img src="https://www.usim.edu.my/wp-content/uploads/2017/02/5-Copy-1.jpg" alt="GISO Syria">
                                </div>
                                <div class="carousel-caption-custom">
                                    <h4>#6 GISO Syria</h4>
                                    <h5>Come 2.0 Mission Accomplished</h5>
                                </div>
                                <div class="slide-counter">6/6</div>
                            </div>
                        </div>

                        <!-- Navigation Controls -->
                        <div class="carousel-control-prev-custom carousel-control-custom" role="button" data-slide="prev">
                            <i class="fas fa-chevron-left"></i>
                        </div>
                        <div class="carousel-control-next-custom carousel-control-custom" role="button" data-slide="next">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
            
            <script>
                $(document).ready(function() {
                    // Initialize carousel with custom settings
                    $('#newsCarousel').carousel({
                        interval: 4000, // 4 seconds between slides
                        pause: 'hover',
                        wrap: true
                    });

                    // Update indicators and counter on slide
                    $('#newsCarousel').on('slide.bs.carousel', function(e) {
                        var $active = $(this).find('.carousel-item.active');
                        var index = $active.index() + 1;
                        
                        // Update indicators
                        $(this).find('.carousel-indicators-custom li').removeClass('active');
                        $(this).find('.carousel-indicators-custom li').eq(e.to).addClass('active');
                        
                        // Update all slide counters
                        $('.carousel-item .slide-counter').each(function(i) {
                            $(this).text((i + 1) + '/6');
                        });
                    });

                    // Custom navigation controls
                    $('.carousel-control-prev-custom').click(function() {
                        $('#newsCarousel').carousel('prev');
                    });

                    $('.carousel-control-next-custom').click(function() {
                        $('#newsCarousel').carousel('next');
                    });

                    // Indicator click
                    $('.carousel-indicators-custom li').click(function() {
                        var slideTo = $(this).data('slide-to');
                        $('#newsCarousel').carousel(slideTo);
                    });

                    // Ensure all images have the same dimensions
                    function adjustCarouselImages() {
                        $('.carousel-image-container').each(function() {
                            var $this = $(this);
                            var currentHeight = $this.height();
                            $this.height(currentHeight);
                            
                            var $img = $this.find('img');
                            $img.css({
                                'width': '100%',
                                'height': '100%',
                                'object-fit': 'cover',
                                'object-position': 'center'
                            });
                        });
                    }

                    // Adjust on load and window resize
                    adjustCarouselImages();
                    $(window).resize(adjustCarouselImages);
                });
            </script>
        <!-- End of Carousel -->


        <style>
        /* Action Arrow */
        .action-arrow {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .action-arrow i {
            font-size: 0.875rem;
        }

        /* Typography */
        h5, h6 {
            font-family: 'Noto Sans', sans-serif;
        }

        h5 {
            font-weight: 600;
            color: #1a1a1a;
        }

        h6 {
            font-weight: 500;
            color: #2d3748;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .quick-actions-section {
                padding: 1.5rem 0 2.5rem;
            }
            
            .quick-action-card {
                padding: 1.5rem !important;
            }
            
            .icon-wrapper {
                width: 48px;
                height: 48px;
            }
            
            .icon-wrapper i {
                font-size: 1.125rem;
            }
        }

        @media (max-width: 768px) {
            .quick-actions-section {
                padding: 1rem 0 2rem;
            }
            
            .row.g-3 {
                row-gap: 1rem !important;
            }
            
            .quick-action-card {
                padding: 1.25rem !important;
            }
        }

        @media (max-width: 576px) {
            .quick-actions-section {
                padding: 0.75rem 0 1.5rem;
            }
            
            .quick-action-card {
                margin-bottom: 0.5rem;
            }
            
            .icon-wrapper {
                width: 44px;
                height: 44px;
                border-radius: 12px;
            }
            
            .icon-wrapper i {
                font-size: 1rem;
            }
        }
        </style>


        <style>
        .clickable-container {
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .clickable-container:hover {
            opacity: 0.8;
        }
        </style>



        <div class="row mb-4">
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-center">
                    <div>
                        <h3 class="font-weight-bold mb-0">Quick Actions</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-5">
            <!-- Column 1: Create Team -->
            <div class="col-md-6 mb-4 px-3">
                <div class="clickable-container" onclick="window.location.href='{{ route('teams.index') }}'">
                    <div class="dashboard-header-actions position-relative border rounded-3 p-4 h-100">
                        <div class="row align-items-center" style="z-index: 2;">
                            <!-- Greeting Section - Left Side -->
                            <div class="col-md-9 col-12">
                                <div class="greeting-section animate-rise my-6">
                                    <h2 class="font-weight-bold ms-3 mb-0">Create your team</h2>
                                </div>
                            </div>
                        </div>
                        <div class="image-container-actions animate-rise-delay">
                            <img src="{{ asset('assets/img/create team dashboard.png') }}" 
                                alt="Create Team Image" 
                                class="header-image img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: My Teams -->
            <div class="col-md-6 mb-4 px-3">
                <div class="clickable-container" onclick="window.location.href='{{ route('teams.index') }}'">
                    <div class="dashboard-header-actions position-relative border rounded-3 p-4 h-100">
                        <div class="row align-items-center" style="z-index: 2;">
                            <!-- Greeting Section - Left Side -->
                            <div class="col-md-9 col-12">
                                <div class="greeting-section animate-rise my-6">
                                    <h2 class="font-weight-bold ms-3 mb-0">My Teams</h2>
                                </div>
                            </div>
                        </div>
                        <div class="image-container-actions animate-rise-delay me-5">
                            <img src="{{ asset('assets/img/my team dashboard.png') }}" 
                                alt="My Teams Image" 
                                class="header-image img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-5">
            <!-- Column 1: Create Team -->
            <div class="col-md-6 mb-4 px-3">
                <div class="clickable-container" onclick="window.location.href='{{ route('presentation-schedules.index') }}'">
                    <div class="dashboard-header-actions position-relative border rounded-3 p-4 h-100">
                        <div class="row align-items-center" style="z-index: 2;">
                            <!-- Greeting Section - Left Side -->
                            <div class="col-md-9 col-12">
                                <div class="greeting-section animate-rise my-6">
                                    <h2 class="font-weight-bold ms-3 mb-0">Presentation Schedules</h2>
                                </div>
                            </div>
                        </div>
                        <div class="image-container-actions animate-rise-delay">
                            <img src="{{ asset('assets/img/schedule-management 3d 2.png') }}" 
                                alt="Create Team Image" 
                                class="header-image img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Column 2: My Teams -->
            <div class="col-md-6 mb-4 px-3">
                <div class="clickable-container" onclick="window.location.href='{{ route('profile') }}'">
                    <div class="dashboard-header-actions position-relative border rounded-3 p-4 h-100">
                        <div class="row align-items-center" style="z-index: 2;">
                            <!-- Greeting Section - Left Side -->
                            <div class="col-md-9 col-12">
                                <div class="greeting-section animate-rise my-6">
                                    <h2 class="font-weight-bold ms-3 mb-0">My Profile</h2>
                                </div>
                            </div>
                        </div>
                        <div class="image-container-actions animate-rise-delay me-5">
                            <img src="{{ asset('assets/img/my profile.png') }}" 
                                alt="My Teams Image" 
                                class="header-image img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <style>
                .image-container-actions {
                    position: absolute;
                    top: -20px; /* Reduced from -50px */
                    right: -10px; /* Reduced from -30px */
                    z-index: 1;
                    max-width: 40%; /* Reduced from 60% */
                }

                .header-image-actions {
                    width: 100%;
                    height: auto;
                    max-height: 200px; /* Reduced from 400px */
                    object-fit: cover;
                    border-radius: 10px; /* Reduced from 20px */
                    transition: transform 0.3s ease;
                }
        </style>


        
</x-app-layout>