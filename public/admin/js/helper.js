// Datatable basic Properties
var datatableProperties = {
    language: {
      searchPlaceholder: 'Search...',
      sSearch: '',
      lengthMenu: '_MENU_ items/page',
    },
    "responsive": true, 
    "lengthChange": false, 
    "autoWidth": false,
    "processing": true,
    "initComplete": renderfun
  };

  function renderfun(settings, json) {

    $('.dataTables_filter input').unbind().bind('keyup', function(e) {
      if(e.keyCode === 13) {
        window.dataTable.search( this.value ).draw();
      }
    });

  }

  $(document).on('click', '.confirm-before-delete', function(e) {
    return confirm("Please confirm if you want to delete?");    
  });


  // Confirm popup before delete
  $(document).on('submit', '.confirm-before-delete', function(e) {
    return confirm("Please confirm if you want to delete?");    
  });

