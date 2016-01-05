<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="@section('keywords'){{ get_option('keywords') }}@show">
    <meta name="description" content="@section('description'){{ get_option('description') }}@show">
    <meta name="author" content="Specs">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@section('title'){{ get_option('sitename') }}@show</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('/css/clean-blog.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
