@php($title = 'Checkout')
@php($description = 'Almost there. Choose your delivery address and payment method to complete your order.')
@php($cards = [['01','Delivery address','Add your preferred address'],['02','Shipping method','Regular delivery · Rp15.000'],['03','Payment','Secure payment powered by Tripay']])
@include('pages.customer.template')
