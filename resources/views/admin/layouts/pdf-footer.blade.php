<htmlpagefooter name="page-footer">
    <div class="footer">
        <div class="left" style="font-size: 8px;">
            @if (Auth::check())
                Printed by : {{ Auth::user()->name }}
            @endif
        </div>
        <div class="center" style="font-size: 8px;">
            Intelli Inventory - System generated report
        </div>
        <div class="right" style="font-size: 8px;">
            Printed date : {{ $date_in_english }} -  {nb}/{PAGENO}
        </div>
    </div>
</htmlpagefooter>