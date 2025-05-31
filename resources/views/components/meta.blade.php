@php
    $author_name = $author_name ?? 'Blog App';
    $description = $description ?? "The best platform to share stories, inspirations, and knowledge. Find a variety of interesting articles in various categories ranging from technology, entertainment, to lifestyle. Join us and start sharing your experiences!";
    $keywords = $keywords ?? 'blog, article, story, inspiration, technology, entertainment, lifestyle, education, personal, experience, sharing, knowledge, community';
    $thumbnail = $thumbnail ?? null;
    $thumbnail = $thumbnail ? asset('storage/thumbnails/' . $thumbnail) : url('assets/images/logo.png');
@endphp

<meta name="description" content="{{ $description }}">
<meta name="keywords" content="{{ $keywords }}">
<meta name="author" content="{{ $author_name }}">

<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $thumbnail }}">
<meta property="og:site_name" content="Blog App">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $thumbnail }}">

<meta name="robots" content="index, follow, max-image-preview:large">
<meta name="googlebot" content="index, follow">

<link rel="canonical" href="{{ url()->current() }}">
<link rel="alternate" href="{{ url()->current() }}" hreflang="x-default">