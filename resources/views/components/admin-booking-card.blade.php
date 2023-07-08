@php
    $isApproved = true;
@endphp
<div>
    <div class="p-card p-2 h-8rem w-full">
        <div>
            <div class="p-card-title">{{$booking}}</div>
            <div class="p-card-subtitle">Subtitle</div>
        </div>
        <div class="flex flex-row gap-1 justify-content-end">
            @if($isApproved)
            <button class="p-button p-1"><i class="pi pi-book p-1"></i></button>
            <button class="p-button p-button-success p-1"><i class="pi pi-pencil p-1"></i></button>
            <button class="p-button p-button-danger p-button-success p-1" ><i class="pi pi-trash p-1"></i></button>
            
            @else
                
            @endif
          </div>
      </div>
      
</div>