<script>
  $(function() {
    let status_success = "{{session()->has('success')}}";
    if(status_success){
      Swal.fire({
        icon: "success",
        title: "{{session()->get('success')}}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    }

    let status_info = "{{session()->has('info')}}";
    if(status_info){
      Swal.fire({
        icon: "info",
        title: "{{session()->get('info')}}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    }

    let status_error = "{{session()->has('error')}}";
    if(status_error){
      Swal.fire({
        icon: "error",
        title: "{{session()->get('error')}}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    }

    let status_warning = "{{session()->has('warning')}}";
    if(status_warning){
      Swal.fire({
        icon: "warning",
        title: "{{session()->has('warning')}}",
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    }
  });
</script>