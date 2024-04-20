<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none">

<!-- Mirrored from kanakku.dreamstechnologies.com/html/template/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 19 Apr 2024 13:32:29 GMT -->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>HRM System - @yield('title')</title>

<link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

<style type="text/css">@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:100;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:200;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:300;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:400;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:500;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:600;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:700;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:800;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic/wght/normal.woff2);unicode-range:U+0301,U+0400-045F,U+0490-0491,U+04B0-04B1,U+2116;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek-ext/wght/normal.woff2);unicode-range:U+1F00-1FFF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/greek/wght/normal.woff2);unicode-range:U+0370-03FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin-ext/wght/normal.woff2);unicode-range:U+0100-02AF,U+0304,U+0308,U+0329,U+1E00-1E9F,U+1EF2-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/latin/wght/normal.woff2);unicode-range:U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,U+0304,U+0308,U+0329,U+2000-206F,U+2074,U+20AC,U+2122,U+2191,U+2193,U+2212,U+2215,U+FEFF,U+FFFD;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/cyrillic-ext/wght/normal.woff2);unicode-range:U+0460-052F,U+1C80-1C88,U+20B4,U+2DE0-2DFF,U+A640-A69F,U+FE2E-FE2F;font-display:swap;}@font-face {font-family:Inter;font-style:normal;font-weight:900;src:url(https://kanakku.dreamstechnologies.com/cf-fonts/v/inter/5.0.16/vietnamese/wght/normal.woff2);unicode-range:U+0102-0103,U+0110-0111,U+0128-0129,U+0168-0169,U+01A0-01A1,U+01AF-01B0,U+0300-0301,U+0303-0304,U+0308-0309,U+0323,U+0329,U+1EA0-1EF9,U+20AB;font-display:swap;}</style>

<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/plugins/feather/feather.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">

<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toatr.css') }}">
<script src="{{ asset('assets/js/layout.js') }}" type="text/javascript"></script>
</head>
<body>

<div class="main-wrapper">

<div class="header header-one">
<a href="index.html" class="d-inline-flex d-sm-inline-flex align-items-center d-md-inline-flex d-lg-none align-items-center device-logo">
<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid logo2" alt="Logo">
</a>
<div class="main-logo d-inline float-start d-lg-flex align-items-center d-none d-sm-none d-md-none">
<div class="logo-white">
<a href="index.html">
<img src="{{ asset('assets/img/logo-full-white.png') }}" class="img-fluid logo-blue" alt="Logo">
</a>
<a href="index.html">
<img src="{{ asset('assets/img/logo-small-white.png') }}" class="img-fluid logo-small" alt="Logo">
</a>
</div>
<div class="logo-color">
<a href="index.html">
<img src="{{ asset('assets/img/logo.png') }}" class="img-fluid logo-blue" alt="Logo">
</a>
<a href="index.html">
<img src="{{ asset('assets/img/logo-small.png') }}" class="img-fluid logo-small" alt="Logo">
</a>
</div>
</div>

<a href="javascript:void(0);" id="toggle_btn">
<span class="toggle-bars">
<span class="bar-icons"></span>
<span class="bar-icons"></span>
<span class="bar-icons"></span>
<span class="bar-icons"></span>
</span>
</a>


<div class="top-nav-search">
<form>
<input type="text" class="form-control" placeholder="Search here">
<button class="btn" type="submit"><img src="{{ asset('assets/img/icons/search.svg') }}" alt="img"></button>
</form>
</div>


<a class="mobile_btn" id="mobile_btn">
<i class="fas fa-bars"></i>
</a>


<ul class="nav nav-tabs user-menu">

<li class="nav-item dropdown has-arrow flag-nav">
<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button">
<img src="{{ asset('assets/img/flags/us1.png') }}" alt="flag"><span>English</span>
</a>
<div class="dropdown-menu dropdown-menu-end">
<a href="javascript:void(0);" class="dropdown-item">
<img src="{{ asset('assets/img/flags/us.png') }}" alt="flag"><span>English</span>
</a>
<a href="javascript:void(0);" class="dropdown-item">
<img src="{{ asset('assets/img/flags/fr.png') }}" alt="flag"><span>French</span>
</a>
<a href="javascript:void(0);" class="dropdown-item">
<img src="{{ asset('assets/img/flags/es.png') }}" alt="flag"><span>Spanish</span>
</a>
<a href="javascript:void(0);" class="dropdown-item">
<img src="{{ asset('assets/img/flags/de.png') }}" alt="flag"><span>German</span>
</a>
</div>
</li>

<li class="nav-item dropdown  flag-nav dropdown-heads">
<a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
<i class="fe fe-bell"></i> <span class="badge rounded-pill"></span>
</a>
<div class="dropdown-menu notifications">
<div class="topnav-dropdown-header">
<div class="notification-title">Notifications <a href="notifications.html">View all</a></div>
<a href="javascript:void(0)" class="clear-noti d-flex align-items-center">Mark all as read <i class="fe fe-check-circle"></i></a>
</div>
<div class="noti-content">
<ul class="notification-list">
<li class="notification-message">
<a href="profile.html">
<div class="d-flex">
<span class="avatar avatar-md active">
<img class="avatar-img rounded-circle" alt="avatar-img" src="{{ asset('assets/img/profiles/avatar-02.jpg') }}">
</span>
<div class="media-body">
<p class="noti-details"><span class="noti-title">Lex Murphy</span> requested access to <span class="noti-title">UNIX directory tree hierarchy</span></p>
<div class="notification-btn">
<span class="btn btn-primary">Accept</span>
<span class="btn btn-outline-primary">Reject</span>
</div>
<p class="noti-time"><span class="notification-time">Today at 9:42 AM</span></p>
</div>
</div>
</a>
</li>

</ul>
</div>
<div class="topnav-dropdown-footer">
<a href="#">Clear All</a>
</div>
</div>
</li>
<li class="nav-item  has-arrow dropdown-heads ">
<a href="javascript:void(0);" class="win-maximize">
<i class="fe fe-maximize"></i>
</a>
</li>

<li class="nav-item dropdown">
<a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
<span class="user-img">
<img src="{{ Auth::user()->image != null ? asset('assets\images\userimages' . Auth::user()->image)  : asset('assets/img/profiles/avatar-07.jpg')}}" alt="img" class="profilesidebar">
<span class="animate-circle"></span>
</span>
<span class="user-content">
<span class="user-details">{{ strtoupper(Auth::user()->role == 1 ? 'Admin' : 'Employee') }}</span>
<span class="user-name">{{ ucfirst(Auth::user()->name) }}</span>
</span>
</a>
<div class="dropdown-menu menu-drop-user">
<div class="profilemenu">
<div class="subscription-menu">
<ul>
<li>
<a class="dropdown-item" href="profile.html">Profile</a>
</li>
<li>
<a class="dropdown-item" href="{{ route('profile_settings' , encrypt(Auth::user()->id)) }}">Settings</a>
</li>
</ul>
</div>
<div class="subscription-logout">
<ul>
<li class="pb-0">
<a class="dropdown-item" href="{{ route('auth.logout') }}">Log Out</a>
</li>
</ul>
</div>
</div>
</div>
</li>

</ul>

</div>


<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<nav class="greedys sidebar-horizantal">
<ul class="list-inline-item list-unstyled links">
<li class="menu-title"><span>Main</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-home"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="index.html" class="active">Admin Dashboard</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-grid"></i> <span> Applications</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="chat.html">Chat</a></li>
<li><a href="calendar.html">Calendar</a></li>
<li><a href="inbox.html">Email</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-user"></i> <span> Super Admin</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="dashboard.html">Dashboard</a></li>
<li><a href="companies.html">Companies</a></li>
<li><a href="subscription.html">Subscription</a></li>
<li><a href="packages.html">Packages</a></li>
<li><a href="domain.html">Domain</a></li>
<li><a href="purchase-transaction.html">Purchase Transaction</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-users"></i><span>Customers</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="customers.html"><i class="fe fe-users"></i> <span>Customers</span></a></li>
<li>
<a href="customer-details.html"><i class="fe fe-file"></i> <span>Customer Details</span></a>
</li>
<li>
<a href="vendors.html"><i class="fe fe-user"></i> <span>Vendors</span></a>
</li>
</ul>
</li>
<li class="menu-title"><span>Inventory</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-package"></i> <span> Products / Services</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="product-list.html">Product List</a></li>
<li><a href="category.html">Category</a></li>
<li><a href="units.html">Units</a></li>
</ul>
</li>
<li>
<a href="inventory.html"><i class="fe fe-user"></i> <span>Inventory</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-file-plus"></i><span>Signature</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="signature-list.html"><i class="fe fe-clipboard"></i> <span>List of Signature</span></a></li>
<li><a href="signature-invoice.html"><i class="fe fe-box"></i> <span>Signature Invoice</span></a></li>
</ul>
</li>
<li class="menu-title"><span>Sales</span></li>
<li class="submenu">
<a href="invoices.html"><i class="fe fe-file"></i> <span>Invoices</span><span class="menu-arrow"></span></a>
<ul>
<li><a href="invoices.html">Invoices List</a></li>
<li><a href="invoice-details-admin.html">Invoice Details (Admin)</a></li>
<li><a href="invoice-details.html">Invoice Details (Customer)</a></li>
<li><a href="invoice-template.html">Invoice Templates</a></li>
</ul>
</li>
</ul>
<button class="viewmoremenu">More Menu</button>
<ul class="hidden-links hidden">
<li>
<a href="recurring-invoices.html"><i class="fe fe-clipboard"></i> <span>Recurring Invoices</span></a>
</li>
<li>
<a href="credit-notes.html"><i class="fe fe-edit"></i> <span>Credit Notes</span></a>
</li>
<li class="menu-title"><span>Purchases</span></li>
<li>
<a href="purchases.html"><i class="fe fe-shopping-cart"></i> <span>Purchases</span></a>
</li>
<li>
<a href="purchase-orders.html"><i class="fe fe-shopping-bag"></i> <span>Purchase Orders</span></a>
</li>
<li>
<a href="debit-notes.html"><i class="fe fe-file-text"></i> <span>Debit Notes</span></a>
</li>
<li class="menu-title"><span>Finance & Accounts</span></li>
<li>
<a href="expenses.html"><i class="fe fe-file-plus"></i> <span>Expenses</span></a>
</li>
<li>
<a href="payments.html"><i class="fe fe-credit-card"></i> <span>Payments</span></a>
</li>
<li class="menu-title"><span>Quotations</span></li>
<li>
<a href="quotations.html"><i class="fe fe-clipboard"></i> <span>Quotations</span></a>
</li>
<li>
<a href="delivery-challans.html"><i class="fe fe-file-text"></i> <span>Delivery Challans</span></a>
</li>
<li class="menu-title"><span>Reports</span></li>
<li>
<a href="payment-summary.html"><i class="fe fe-credit-card"></i> <span>Payment Summary</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-box"></i><span>Reports</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="expense-report.html">Expense Report</a></li>
<li><a href="purchase-report.html">Purchase Report</a></li>
<li><a href="purchase-return.html">Purchase Return Report</a></li>
<li><a href="sales-report.html">Sales Report</a></li>
<li><a href="sales-return-report.html">Sales Return Report</a></li>
<li><a href="quotation-report.html">Quotation Report</a></li>
<li><a href="payment-report-2.html">Payment Report</a></li>
<li><a href="stock-report.html">Stock Report</a></li>
<li><a href="low-stock-report.html">Low Stock Report</a></li>
<li><a href="income-report.html">Income Report</a></li>
<li><a href="tax-purchase.html">Tax Report</a></li>
<li><a href="profit-loss-list.html">Profit & Loss</a></li>
</ul>
</li>
<li class="menu-title"><span>User Management</span></li>
<li>
<a href="users.html"><i class="fe fe-user"></i> <span>Users</span></a>
</li>
<li>
<a href="roles-permission.html"><i class="fe fe-clipboard"></i> <span>Roles & Permission</span></a>
</li>
<li>
<a href="delete-account-request.html"><i class="fe fe-trash-2"></i> <span>Delete Account Request</span></a>
</li>
<li class="menu-title"><span>Membership</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-book"></i> <span> Membership</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="membership-plans.html">Membership Plans</a></li>
<li><a href="membership-addons.html">Membership Addons</a></li>
<li><a href="subscribers.html">Subscribers</a></li>
<li><a href="transactions.html">Transactions</a></li>
</ul>
</li>
<li class="menu-title"><span>Content (CMS)</span></li>
<li>
<a href="pages.html"><i class="fe fe-folder"></i> <span>Pages</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-book"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="all-blogs.html">All Blogs</a></li>
<li><a href="categories.html">Categories</a></li>
<li><a href="blog-comments.html">Blog Comments</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-map-pin"></i> <span> Location</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="countries.html">Countries</a></li>
<li><a href="states.html">States</a></li>
<li><a href="cities.html">Cities</a></li>
</ul>
</li>
<li>
<a href="testimonials.html"><i class="fe fe-message-square"></i> <span>Testimonials</span></a>
</li>
<li>
<a href="faq.html"><i class="fe fe-alert-circle"></i> <span>FAQ</span></a>
</li>
<li class="menu-title"><span>Support</span></li>
<li>
<a href="contact-messages.html"><i class="fe fe-printer"></i> <span>Contact Messages</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-save"></i> <span> Tickets</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="tickets.html">Tickets</a></li>
<li><a href="tickets-list.html">Tickets List</a></li>
<li><a href="tickets-kanban.html">Tickets Kanban</a></li>
<li><a href="ticket-details.html">Ticket Overview</a></li>
</ul>
</li>
<li class="menu-title"><span>Pages</span></li>
<li>
<a href="profile.html"><i class="fe fe-user"></i> <span>Profile</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-lock"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="login.html"> Login </a></li>
<li><a href="register.html"> Register </a></li>
<li><a href="forgot-password.html"> Forgot Password </a></li>
<li><a href="lock-screen.html"> Lock Screen </a></li>
</ul>
</li>
<li>
<a href="error-404.html"><i class="fe fe-x-square"></i> <span>Error Pages</span></a>
</li>
<li>
<a href="blank-page.html"><i class="fe fe-file"></i> <span>Blank Page</span></a>
</li>
<li>
<a href="maps-vector.html"><i class="fe fe-image"></i> <span>Vector Maps</span></a>
</li>
<li class="menu-title">
<span>UI Interface</span>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-pocket"></i> <span>Base UI </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="alerts.html">Alerts</a></li>
<li><a href="accordions.html">Accordions</a></li>
<li><a href="avatar.html">Avatar</a></li>
<li><a href="badges.html">Badges</a></li>
<li><a href="buttons.html">Buttons</a></li>
<li><a href="buttongroup.html">Button Group</a></li>
<li><a href="breadcrumbs.html">Breadcrumb</a></li>
<li><a href="cards.html">Cards</a></li>
<li><a href="carousel.html">Carousel</a></li>
<li><a href="dropdowns.html">Dropdowns</a></li>
<li><a href="grid.html">Grid</a></li>
<li><a href="images.html">Images</a></li>
<li><a href="lightbox.html">Lightbox</a></li>
<li><a href="media.html">Media</a></li>
<li><a href="modal.html">Modals</a></li>
<li><a href="offcanvas.html">Offcanvas</a></li>
<li><a href="pagination.html">Pagination</a></li>
<li><a href="popover.html">Popover</a></li>
<li><a href="progress.html">Progress Bars</a></li>
<li><a href="placeholders.html">Placeholders</a></li>
<li><a href="rangeslider.html">Range Slider</a></li>
<li><a href="spinners.html">Spinner</a></li>
<li><a href="sweetalerts.html">Sweet Alerts</a></li>
<li><a href="tab.html">Tabs</a></li>
<li><a href="toastr.html">Toasts</a></li>
<li><a href="tooltip.html">Tooltip</a></li>
<li><a href="typography.html">Typography</a></li>
<li><a href="video.html">Video</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-box"></i> <span>Elements </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="ribbon.html">Ribbon</a></li>
<li><a href="clipboard.html">Clipboard</a></li>
<li><a href="drag-drop.html">Drag & Drop</a></li>
<li><a href="rating.html">Rating</a></li>
<li><a href="text-editor.html">Text Editor</a></li>
<li><a href="counter.html">Counter</a></li>
<li><a href="scrollbar.html">Scrollbar</a></li>
<li><a href="notification.html">Notification</a></li>
<li><a href="stickynote.html">Sticky Note</a></li>
<li><a href="timeline.html">Timeline</a></li>
<li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
<li><a href="form-wizard.html">Form Wizard</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-bar-chart"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="chart-apex.html">Apex Charts</a></li>
<li><a href="chart-js.html">Chart Js</a></li>
<li><a href="chart-morris.html">Morris Charts</a></li>
<li><a href="chart-flot.html">Flot Charts</a></li>
<li><a href="chart-peity.html">Peity Charts</a></li>
<li><a href="chart-c3.html">C3 Charts</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-award"></i> <span> Icons </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
<li><a href="icon-feather.html">Feather Icons</a></li>
<li><a href="icon-ionic.html">Ionic Icons</a></li>
<li><a href="icon-material.html">Material Icons</a></li>
<li><a href="icon-pe7.html">Pe7 Icons</a></li>
<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
<li><a href="icon-themify.html">Themify Icons</a></li>
<li><a href="icon-weather.html">Weather Icons</a></li>
<li><a href="icon-typicon.html">Typicon Icons</a></li>
<li><a href="icon-flag.html">Flag Icons</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-sidebar"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="form-basic-inputs.html">Basic Inputs </a></li>
<li><a href="form-input-groups.html">Input Groups </a></li>
<li><a href="form-horizontal.html">Horizontal Form </a></li>
<li><a href="form-vertical.html"> Vertical Form </a></li>
<li><a href="form-mask.html">Form Mask </a></li>
<li><a href="form-validation.html">Form Validation </a></li>
<li><a href="form-select2.html">Form Select2 </a></li>
<li><a href="form-fileupload.html">File Upload </a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-layout"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="tables-basic.html">Basic Tables </a></li>
<li><a href="data-tables.html">Data Table </a></li>
</ul>
</li>
<li class="menu-title"><span>Settings</span></li>
<li>
<a href="settings.html"><i class="fe fe-settings"></i> <span>Settings</span></a>
</li>
<li class="menu-title">
<span>Extras</span>
</li>
<li>
<a href="#"><i class="fe fe-file-text"></i> <span>Documentation</span></a>
</li>
<li>
<a href="javascript:void(0);"><i class="fe fe-lock"></i> <span>Change Log</span> <span class="badge badge-primary ms-auto">v2.0.4</span></a>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i class="fa fa-list"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li class="submenu">
<a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
<ul style="display: none;" class="level2">
<li><a href="javascript:void(0);"><span>Level 2</span></a></li>
<li class="submenu">
<a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
<ul style="display: none;" class="level3">
<li><a href="javascript:void(0);">Level 3</a></li>
<li><a href="javascript:void(0);">Level 3</a></li>
</ul>
</li>
<li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
</ul>
</li>
<li>
<a href="javascript:void(0);"> <span>Level 1</span></a>
</li>
</ul>
</li>
<li>
<a href="{{ route('auth.logout') }}"><i class="fe fe-power"></i> <span>Logout</span></a>
</li>
</ul>

</nav>
<ul class="sidebar-vertical">

<li class="menu-title"><span>Main</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-home"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a class="active" href="index.html">Admin Dashboard</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-grid"></i> <span> Applications</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="chat.html">Chat</a></li>
<li><a href="calendar.html">Calendar</a></li>
<li><a href="inbox.html">Email</a></li>
</ul>
</li>

<li class="submenu">
<a href="#" class><i class="fe fe-user"></i> <span> Super Admin</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="dashboard.html">Dashboard</a></li>
<li><a href="companies.html">Companies</a></li>
<li><a href="subscription.html">Subscription</a></li>
<li><a href="packages.html">Packages</a></li>
<li><a href="domain.html">Domain</a></li>
<li><a href="purchase-transaction.html">Purchase Transaction</a></li>
</ul>
</li>

<li class="menu-title"><span>Customers</span></li>
<li>
<a href="customers.html"><i class="fe fe-users"></i> <span>Customers</span></a>
</li>
<li>
<a href="customer-details.html"><i class="fe fe-file"></i> <span>Customer Details</span></a>
</li>
<li>
<a href="vendors.html"><i class="fe fe-user"></i> <span>Vendors</span></a>
</li>


<li class="menu-title"><span>Inventory</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-package"></i> <span> Products / Services</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="product-list.html">Product List</a></li>
<li><a href="category.html">Category</a></li>
<li><a href="units.html">Units</a></li>
</ul>
</li>
<li>
<a href="inventory.html"><i class="fe fe-user"></i> <span>Inventory</span></a>
</li>


<li class="menu-title"><span>Signature</span></li>
<li>
<a href="signature-list.html"><i class="fe fe-clipboard"></i> <span>List of Signature</span></a>
<a href="signature-invoice.html"><i class="fe fe-box"></i> <span>Signature Invoice</span></a>
</li>


<li class="menu-title"><span>Sales</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-file"></i> <span>Invoices</span><span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="invoices.html">Invoices List</a></li>
<li><a href="invoice-details-admin.html">Invoice Details (Admin)</a></li>
<li><a href="invoice-details.html">Invoice Details (Customer)</a></li>
<li><a href="invoice-template.html">Invoice Templates</a></li>
</ul>
</li>
<li>
<a href="recurring-invoices.html"><i class="fe fe-clipboard"></i> <span>Recurring Invoices</span></a>
</li>
<li>
<a href="credit-notes.html"><i class="fe fe-edit"></i> <span>Credit Notes</span></a>
</li>


<li class="menu-title"><span>Purchases</span></li>
<li>
<a href="purchases.html"><i class="fe fe-shopping-cart"></i> <span>Purchases</span></a>
</li>
<li>
<a href="purchase-orders.html"><i class="fe fe-shopping-bag"></i> <span>Purchase Orders</span></a>
</li>
<li>
<a href="debit-notes.html"><i class="fe fe-file-text"></i> <span>Debit Notes</span></a>
</li>


<li class="menu-title"><span>Finance & Accounts</span></li>
<li>
<a href="expenses.html"><i class="fe fe-file-plus"></i> <span>Expenses</span></a>
</li>
<li>
<a href="payments.html"><i class="fe fe-credit-card"></i> <span>Payments</span></a>
</li>


<li class="menu-title"><span>Quotations</span></li>
<li>
<a href="quotations.html"><i class="fe fe-clipboard"></i> <span>Quotations</span></a>
</li>
<li>
<a href="delivery-challans.html"><i class="fe fe-file-text"></i> <span>Delivery Challans</span></a>
</li>


<li class="menu-title"><span>Reports</span></li>
<li>
<a href="payment-summary.html"><i class="fe fe-credit-card"></i> <span>Payment Summary</span></a>
</li>

<li class="submenu">
<a href="#"><i class="fe fe-box"></i><span>Reports</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="expense-report.html">Expense Report</a></li>
<li><a href="purchase-report.html">Purchase Report</a></li>
<li><a href="purchase-return.html">Purchase Return Report</a></li>
<li><a href="sales-report.html">Sales Report</a></li>
<li><a href="sales-return-report.html">Sales Return Report</a></li>
<li><a href="quotation-report.html">Quotation Report</a></li>
<li><a href="payment-report.html">Payment Report</a></li>
<li><a href="stock-report.html">Stock Report</a></li>
<li><a href="low-stock-report.html">Low Stock Report</a></li>
<li><a href="income-report.html">Income Report</a></li>
<li><a href="tax-purchase.html">Tax Report</a></li>
<li><a href="profit-loss-list.html">Profit & Loss</a></li>
</ul>
</li>

<li class="menu-title"><span>User Management</span></li>
<li>
<a href="users.html"><i class="fe fe-user"></i> <span>Users</span></a>
</li>
<li>
<a href="roles-permission.html"><i class="fe fe-clipboard"></i> <span>Roles & Permission</span></a>
</li>
<li>
<a href="delete-account-request.html"><i class="fe fe-trash-2"></i> <span>Delete Account Request</span></a>
</li>


<li class="menu-title"><span>Membership</span></li>
<li class="submenu">
<a href="#"><i class="fe fe-book"></i> <span> Membership</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="membership-plans.html">Membership Plans</a></li>
<li><a href="membership-addons.html">Membership Addons</a></li>
<li><a href="subscribers.html">Subscribers</a></li>
<li><a href="transactions.html">Transactions</a></li>
</ul>
</li>


<li class="menu-title"><span>Content (CMS)</span></li>
<li>
<a href="pages.html"><i class="fe fe-folder"></i> <span>Pages</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-book"></i> <span> Blog</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="all-blogs.html">All Blogs</a></li>
<li><a href="categories.html">Categories</a></li>
<li><a href="blog-comments.html">Blog Comments</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-map-pin"></i> <span> Location</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="countries.html">Countries</a></li>
<li><a href="states.html">States</a></li>
<li><a href="cities.html">Cities</a></li>
</ul>
</li>
<li>
<a href="testimonials.html"><i class="fe fe-message-square"></i> <span>Testimonials</span></a>
</li>
<li>
<a href="faq.html"><i class="fe fe-alert-circle"></i> <span>FAQ</span></a>
</li>


<li class="menu-title"><span>Support</span></li>
<li>
<a href="contact-messages.html"><i class="fe fe-printer"></i> <span>Contact Messages</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-save"></i> <span> Tickets</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="tickets.html">Tickets</a></li>
<li><a href="tickets-list.html">Tickets List</a></li>
<li><a href="tickets-kanban.html">Tickets Kanban</a></li>
<li><a href="ticket-details.html">Ticket Overview</a></li>
</ul>
</li>


<li class="menu-title"><span>Pages</span></li>
<li>
<a href="profile.html"><i class="fe fe-user"></i> <span>Profile</span></a>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-lock"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="login.html"> Login </a></li>
<li><a href="register.html"> Register </a></li>
<li><a href="forgot-password.html"> Forgot Password </a></li>
<li><a href="lock-screen.html"> Lock Screen </a></li>
</ul>
</li>
<li>
<a href="error-404.html"><i class="fe fe-x-square"></i> <span>Error Pages</span></a>
</li>
<li>
<a href="blank-page.html"><i class="fe fe-file"></i> <span>Blank Page</span></a>
</li>
<li>
<a href="maps-vector.html"><i class="fe fe-image"></i> <span>Vector Maps</span></a>
</li>


<li class="menu-title">
<span>UI Interface</span>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-pocket"></i> <span>Base UI </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="alerts.html">Alerts</a></li>
<li><a href="accordions.html">Accordions</a></li>
<li><a href="avatar.html">Avatar</a></li>
<li><a href="badges.html">Badges</a></li>
<li><a href="buttons.html">Buttons</a></li>
<li><a href="buttongroup.html">Button Group</a></li>
<li><a href="breadcrumbs.html">Breadcrumb</a></li>
<li><a href="cards.html">Cards</a></li>
<li><a href="carousel.html">Carousel</a></li>
<li><a href="dropdowns.html">Dropdowns</a></li>
<li><a href="grid.html">Grid</a></li>
<li><a href="images.html">Images</a></li>
<li><a href="lightbox.html">Lightbox</a></li>
<li><a href="media.html">Media</a></li>
<li><a href="modal.html">Modals</a></li>
<li><a href="offcanvas.html">Offcanvas</a></li>
<li><a href="pagination.html">Pagination</a></li>
<li><a href="popover.html">Popover</a></li>
<li><a href="progress.html">Progress Bars</a></li>
<li><a href="placeholders.html">Placeholders</a></li>
<li><a href="rangeslider.html">Range Slider</a></li>
<li><a href="spinners.html">Spinner</a></li>
<li><a href="sweetalerts.html">Sweet Alerts</a></li>
<li><a href="tab.html">Tabs</a></li>
<li><a href="toastr.html">Toasts</a></li>
<li><a href="tooltip.html">Tooltip</a></li>
<li><a href="typography.html">Typography</a></li>
<li><a href="video.html">Video</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-box"></i> <span>Elements </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="ribbon.html">Ribbon</a></li>
<li><a href="clipboard.html">Clipboard</a></li>
<li><a href="drag-drop.html">Drag & Drop</a></li>
<li><a href="rating.html">Rating</a></li>
<li><a href="text-editor.html">Text Editor</a></li>
<li><a href="counter.html">Counter</a></li>
<li><a href="scrollbar.html">Scrollbar</a></li>
<li><a href="notification.html">Notification</a></li>
<li><a href="stickynote.html">Sticky Note</a></li>
<li><a href="timeline.html">Timeline</a></li>
<li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
<li><a href="form-wizard.html">Form Wizard</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-bar-chart"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="chart-apex.html">Apex Charts</a></li>
<li><a href="chart-js.html">Chart Js</a></li>
<li><a href="chart-morris.html">Morris Charts</a></li>
<li><a href="chart-flot.html">Flot Charts</a></li>
<li><a href="chart-peity.html">Peity Charts</a></li>
<li><a href="chart-c3.html">C3 Charts</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-award"></i> <span> Icons </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
<li><a href="icon-feather.html">Feather Icons</a></li>
<li><a href="icon-ionic.html">Ionic Icons</a></li>
<li><a href="icon-material.html">Material Icons</a></li>
<li><a href="icon-pe7.html">Pe7 Icons</a></li>
<li><a href="icon-simpleline.html">Simpleline Icons</a></li>
<li><a href="icon-themify.html">Themify Icons</a></li>
<li><a href="icon-weather.html">Weather Icons</a></li>
<li><a href="icon-typicon.html">Typicon Icons</a></li>
<li><a href="icon-flag.html">Flag Icons</a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-sidebar"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="form-basic-inputs.html">Basic Inputs </a></li>
<li><a href="form-input-groups.html">Input Groups </a></li>
<li><a href="form-horizontal.html">Horizontal Form </a></li>
<li><a href="form-vertical.html"> Vertical Form </a></li>
<li><a href="form-mask.html">Form Mask </a></li>
<li><a href="form-validation.html">Form Validation </a></li>
<li><a href="form-select2.html">Form Select2 </a></li>
<li><a href="form-fileupload.html">File Upload </a></li>
</ul>
</li>
<li class="submenu">
<a href="#"><i class="fe fe-layout"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li><a href="tables-basic.html">Basic Tables </a></li>
<li><a href="data-tables.html">Data Table </a></li>
</ul>
</li>




<li class="menu-title">
<span>Extras</span>
</li>
<li>
<a href="#"><i class="fe fe-file-text"></i> <span>Documentation</span></a>
</li>
<li>
<a href="javascript:void(0);"><i class="fe fe-lock"></i> <span>Change Log</span> <span class="badge badge-primary ms-auto">v2.0.4</span></a>
</li>
<li class="submenu">
<a href="javascript:void(0);"><i class="fa fa-list"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
<ul style="display: none;">
<li class="submenu">
<a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
<ul style="display: none;" class="level2">
<li><a href="javascript:void(0);"><span>Level 2</span></a></li>
<li class="submenu">
<a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
<ul style="display: none;" class="level3">
<li><a href="javascript:void(0);">Level 3</a></li>
<li><a href="javascript:void(0);">Level 3</a></li>
</ul>
</li>
<li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
</ul>
</li>
<li>
<a href="javascript:void(0);"> <span>Level 1</span></a>
</li>
</ul>
</li>
<li class="menu-title"><span>Settings</span></li>
<li>
<a href="settings.html"><i class="fe fe-settings"></i> <span>Settings</span></a>
</li>
<li>
<a href="{{ route('auth.logout') }}"><i class="fe fe-power"></i> <span>Logout</span></a>
</li>
</ul>
</div>
</div>
</div>

<div class="page-wrapper">
    <div class="content container-fluid">
    <div class="row">
            @yield('content')
        </div>
    </div>
</div>
{{-- Main Wrapper ends --}}

</div>


<div class="settings-icon">
<span data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas"><img src="{{ asset('assets/img/icons/siderbar-icon2.svg') }}" class="feather-five" alt="layout"></span>
</div>
<div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="theme-settings-offcanvas">
<div class="sidebar-headerset">
<div class="sidebar-headersets">
<h2>Customizer</h2>
<h3>Customize your overview Page layout</h3>
</div>
<div class="sidebar-headerclose">
<a data-bs-dismiss="offcanvas" aria-label="Close"><img src="{{ asset('assets/img/close.png') }}" alt="img"></a>
</div>
</div>
<div class="offcanvas-body p-0">
<div data-simplebar class="h-100">
<div class="settings-mains">
<div class="layout-head">
<h5>Layout</h5>
<h6>Choose your layout</h6>
</div>
<div class="row">
<div class="col-4">
<div class="form-check card-radio p-0">
<input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input">
<label class="form-check-label avatar-md w-100" for="customizer-layout01">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Vertical</h5>
</div>
<div class="col-4">
<div class="form-check card-radio p-0">
<input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input">
<label class="form-check-label  avatar-md w-100" for="customizer-layout02">
<img src="{{ asset('assets/img/horizontal.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Horizontal</h5>
</div>
<div class="col-4 d-none">
<div class="form-check card-radio p-0">
<input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn" class="form-check-input">
<label class="form-check-label  avatar-md w-100" for="customizer-layout03">
<img src="{{ asset('assets/img/two-col.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Two Column</h5>
</div>
</div>

<div class="layout-head pt-3">
<h5>Color Scheme</h5>
<h6>Choose Light or Dark Scheme.</h6>
</div>
<div class="colorscheme-cardradio">
<div class="row">
<div class="col-4">
<div class="form-check card-radio blue  p-0 ">
<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-blue" value="blue">
<label class="form-check-label  avatar-md w-100" for="layout-mode-blue">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2 mb-2">Blue</h5>
</div>
<div class="col-4">
<div class="form-check card-radio p-0">
<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-light" value="light">
<label class="form-check-label  avatar-md w-100" for="layout-mode-light">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2 mb-2">Light</h5>
</div>
<div class="col-4">
<div class="form-check card-radio dark  p-0 ">
<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-dark" value="dark">
<label class="form-check-label avatar-md w-100 " for="layout-mode-dark">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2 mb-2">Dark</h5>
</div>
<div class="col-4 d-none">
<div class="form-check card-radio p-0">
<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-orange" value="orange">
<label class="form-check-label  avatar-md w-100 " for="layout-mode-orange">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2 mb-2">Orange</h5>
</div>
<div class="col-4 d-none">
<div class="form-check card-radio maroon p-0">
<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-maroon" value="maroon">
<label class="form-check-label  avatar-md w-100 " for="layout-mode-maroon">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2 mb-2">Brink Pink</h5>
</div>
<div class="col-4 d-none">
<div class="form-check card-radio purple p-0">
<input class="form-check-input" type="radio" name="data-layout-mode" id="layout-mode-purple" value="purple">
<label class="form-check-label  avatar-md w-100 " for="layout-mode-purple">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2 mb-2">Green</h5>
</div>
</div>
</div>
<div id="layout-width">
<div class="layout-head pt-3">
<h5>Layout Width</h5>
<h6>Choose Fluid or Boxed layout.</h6>
</div>
<div class="row">
<div class="col-4">
<div class="form-check card-radio p-0">
<input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-fluid" value="fluid">
<label class="form-check-label avatar-md w-100" for="layout-width-fluid">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Fluid</h5>
</div>
<div class="col-4">
<div class="form-check card-radio p-0 ">
<input class="form-check-input" type="radio" name="data-layout-width" id="layout-width-boxed" value="boxed">
<label class="form-check-label avatar-md w-100 px-2" for="layout-width-boxed">
<img src="{{ asset('assets/img/boxed.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Boxed</h5>
</div>
</div>
</div>
<div id="layout-position" class="d-none">
<div class="layout-head pt-3">
<h5>Layout Position</h5>
<h6>Choose Fixed or Scrollable Layout Position.</h6>
</div>
<div class="btn-group bor-rad-50 overflow-hidden radio" role="group">
<input type="radio" class="btn-check" name="data-layout-position" id="layout-position-fixed" value="fixed">
<label class="btn btn-light w-sm" for="layout-position-fixed">Fixed</label>
<input type="radio" class="btn-check" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
<label class="btn btn-light w-sm ms-0" for="layout-position-scrollable">Scrollable</label>
</div>
</div>
<div class="layout-head pt-3">
<h5>Topbar Color</h5>
<h6>Choose Light or Dark Topbar Color.</h6>
</div>
<div class="row">
<div class="col-4">
<div class="form-check card-radio  p-0">
<input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-light" value="light">
<label class="form-check-label avatar-md w-100" for="topbar-color-light">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Light</h5>
</div>
<div class="col-4">
<div class="form-check card-radio p-0">
<input class="form-check-input" type="radio" name="data-topbar" id="topbar-color-dark" value="dark">
<label class="form-check-label  avatar-md w-100" for="topbar-color-dark">
<img src="{{ asset('assets/img/dark.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Dark</h5>
</div>
</div>
<div id="sidebar-size">
<div class="layout-head pt-3">
<h5>Sidebar Size</h5>
<h6>Choose a size of Sidebar.</h6>
</div>
<div class="row">
<div class="col-4">
<div class="form-check sidebar-setting card-radio  p-0 ">
<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-default" value="lg">
<label class="form-check-label avatar-md w-100" for="sidebar-size-default">
<img src="{{ asset('assets/img/vertical.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Default</h5>
</div>
<div class="col-4 d-none">
<div class="form-check sidebar-setting card-radio p-0">
<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-compact" value="md">
<label class="form-check-label  avatar-md w-100" for="sidebar-size-compact">
<img src="{{ asset('assets/img/compact.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Compact</h5>
</div>
<div class="col-4">
<div class="form-check sidebar-setting card-radio p-0 ">
<input class="form-check-input" type="radio" name="data-sidebar-size" id="sidebar-size-small-hover" value="md">
<label class="form-check-label avatar-md w-100" for="sidebar-size-small-hover">
<img src="{{ asset('assets/img/small-hover.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Small Sidebar</h5>
</div>
</div>
</div>
<div id="sidebar-view">
<div class="layout-head pt-3">
<h5>Sidebar View</h5>
<h6>Choose Default or Detached Sidebar view.</h6>
</div>
<div class="row">
<div class="col-4">
<div class="form-check sidebar-setting card-radio  p-0">
<input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-default" value="default">
<label class="form-check-label avatar-md w-100" for="sidebar-view-default">
<img src="{{ asset('assets/img/compact.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Default</h5>
</div>
<div class="col-4">
<div class="form-check sidebar-setting card-radio p-0">
<input class="form-check-input" type="radio" name="data-layout-style" id="sidebar-view-detached" value="detached">
<label class="form-check-label  avatar-md w-100" for="sidebar-view-detached">
<img src="{{ asset('assets/img/detached.png') }}" alt="img">
</label>
</div>
<h5 class="fs-13 text-center mt-2">Detached</h5>
</div>
</div>
</div>
<div id="sidebar-color">
<div class="layout-head pt-3">
<h5>Sidebar Color</h5>
<h6>Choose a color of Sidebar.</h6>
</div>
<div class="row">
<div class="col-4">
<div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
<input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-light" value="light">
<label class="form-check-label  avatar-md w-100" for="sidebar-color-light">
<span class="bg-light bg-sidebarcolor"></span>
</label>
</div>
<h5 class="fs-13 text-center mt-2">Light</h5>
</div>
<div class="col-4">
<div class="form-check sidebar-setting card-radio p-0" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient.show">
<input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-dark" value="dark">
<label class="form-check-label  avatar-md w-100" for="sidebar-color-dark">
<span class="bg-darks bg-sidebarcolor"></span>
</label>
</div>
<h5 class="fs-13 text-center mt-2">Dark</h5>
</div>
<div class="col-4 d-none">
<div class="form-check sidebar-setting card-radio p-0">
<input class="form-check-input" type="radio" name="data-sidebar" id="sidebar-color-gradient" value="gradient">
<label class="form-check-label avatar-md w-100" for="sidebar-color-gradient">
<span class="bg-gradients bg-sidebarcolor"></span>
</label>
</div>
<h5 class="fs-13 text-center mt-2">Gradient</h5>
</div>
<div class="col-4 d-none">
<button class="btn btn-link avatar-md w-100 p-0 overflow-hidden border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBgGradient" aria-expanded="false">
<span class="d-flex gap-1 h-100">
<span class="flex-shrink-0">
<span class="bg-vertical-gradient d-flex h-100 flex-column gap-1 p-1">
<span class="d-block p-1 px-2 bg-soft-light rounded mb-2"></span>
<span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
<span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
<span class="d-block p-1 px-2 pb-0 bg-soft-light"></span>
</span>
</span>
<span class="flex-grow-1">
<span class="d-flex h-100 flex-column">
<span class="bg-light d-block p-1"></span>
<span class="bg-light d-block p-1 mt-auto"></span>
</span>
</span>
</span>
</button>
<h5 class="fs-13 text-center mt-2">Gradient</h5>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="offcanvas-footer border-top p-3 text-center">
<div class="row">
<div class="col-6">
<button type="button" class="btn btn-light w-100 bor-rad-50" id="reset-layout">Reset</button>
</div>

</div>
</div>
</div>


<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/feather.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/theme-settings.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/greedynav.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

</body>
    @if (Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}');
    </script>
    @endif
    @if (Session::has('error'))
    <script>
        toastr.error('{{ Session::get('error') }}');
    </script>
    @endif
@stack('js')
</html>
