@php($title = 'My account')
@php($description = 'Manage your personal details, addresses, and order preferences in one place.')
@php($cards = [['01','Personal details','Name, email, and phone number'],['02','Order history','Track your latest Kembang order'],['03','Saved addresses','Home, office, or your favourite place']])
@include('pages.customer.template')
