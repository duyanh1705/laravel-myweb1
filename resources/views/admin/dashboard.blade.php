{{-- thừa kế layout/view admin.blade.php --}}
{{-- resources/views/admin/layouts/admin.blade.php --}}
@extends('admin.layouts.admin')

{{-- Gán nội dung cho vùng section 'title'  --}}
{{-- (tương ứng với @yield('title') trong layout --}}
@section('title', 'Xin chào')

{{-- Gán nội dung cho vùng section 'content'  --}}
{{-- (tương ứng với @yield('content') trong layout --}}
@section('content')
    <h1>My Dashboard</h1>
@endsection