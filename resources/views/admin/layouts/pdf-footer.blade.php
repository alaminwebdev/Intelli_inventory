<htmlpagefooter name="page-footer">
    <div class="footer">
        <div class="left" style="font-size: 8px;">
            @if (Auth::check())
                {{ Auth::user()->name }} দ্বারা মুদ্রিত
            @endif
        </div>
        <div class="center" style="font-size: 8px;">
            স্পেশাল ব্রাঞ্চ - সিস্টেম জেনারেট রিপোর্ট
        </div>
        <div class="right" style="font-size: 8px;">
            মুদ্রণ তারিখ : {{ $date_in_bengali }} -  {nb}/{PAGENO}
        </div>
    </div>
</htmlpagefooter>