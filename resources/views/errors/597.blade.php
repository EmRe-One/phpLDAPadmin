@extends('architect::layouts.error')

@section('error')
	597: @lang('LDAP Server Unavailable')
@endsection

@section('content')
	{{ $exception->getMessage() }}
@endsection