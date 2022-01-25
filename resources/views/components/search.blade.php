@props(['size' => 50, 'color' => 'gray'])
@php
switch ($color) { //error
case 'gray':
$col = "#374151";
break;
case 'white':
$col = "#ffffff";
break;
default:
$col = "#374151";
break;
}
@endphp
<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
     width="{{ $size }}" height="{{ $size }}"
     viewBox="0 0 226 226"
     style=" fill:#000000;"><g fill="{{ $col }}" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,226v-226h226v226z" fill="none"></path><g fill="#ecf0f1"><path d="M134.1875,21.1875c-38.92652,0 -70.625,31.69848 -70.625,70.625c0,16.91138 5.9314,32.41577 15.89063,44.58203l-56.2793,56.2793l10.15234,10.15234l56.2793,-56.2793c12.16626,9.95923 27.67066,15.89063 44.58203,15.89063c38.92652,0 70.625,-31.69848 70.625,-70.625c0,-38.92652 -31.69848,-70.625 -70.625,-70.625zM134.1875,35.3125c31.28467,0 56.5,25.21534 56.5,56.5c0,31.28467 -25.21533,56.5 -56.5,56.5c-31.28466,0 -56.5,-25.21533 -56.5,-56.5c0,-31.28466 25.21534,-56.5 56.5,-56.5z"></path></g></g></svg>
