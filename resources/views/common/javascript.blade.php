<script>
    @if(Auth::check()===false)
        const iam = null;
    @else
        const iam = {!! Auth::user(); !!};
    @endif
</script>