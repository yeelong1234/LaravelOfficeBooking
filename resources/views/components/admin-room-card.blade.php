<div>
    <div class="p-card p-2 h-7rem w-full border-round">
      <div>
        <div class="p-card-title">{{$roomDetails->name}}</div>
        <div class="p-card-subtitle">Subtitle</div>
      </div>
      <div class="flex flex-row gap-1 justify-content-end">
          @if($isApproved)
          <button class="p-button p-1 tooltip" data-tooltip="View Details"><i class="pi pi-book p-1"></i></button>
          <button class="p-button p-button-success p-1"><i class="pi pi-pencil p-1"></i></button>
          <button class="p-button p-button-danger p-button-success p-1" ><i class="pi pi-trash p-1"></i></button>

          @else
            <button class="p-button p-button-success p-1"><i class="pi pi-check p-1"></i></button>
            <button class="p-button p-button-danger p-button-success p-1" ><i class="pi pi-times p-1"></i></button>

          @endif
      </div>
        
    </div>
</div>