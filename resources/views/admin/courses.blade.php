@extends('layout.base') 
 

@section('content')  
<!-- Content Header (Page header) -->
   <div class="content-header">
       <div class="container-fluid">
         <div class="row mb-2 d-flex justify-content-between">
           <div class="col-sm-6">
             <h1 class="m-0">Lesson Editor</h1>
           </div><!-- /.col -->
           <div>
             <button class="btn btn-primary" onclick="openAddCourseModal()">Add Course</button>
           </div><!-- /.col -->
         </div><!-- /.row -->
       </div><!-- /.container-fluid -->
     </div>
     <!-- /.content-header -->
 
     <!-- Main content -->
     <div class="content">
       <div class="container-fluid">
         <div class="row">
           <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Course Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="table" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Course</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($courses as $course)        
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $course->course_name }}</td>
                  <td>
                    <a href="/admin/courses/setting/{{$course->course_id}}" class="badge badge-warning">Setting</a>
                    <a href="/admin/courses/{{$course->course_id}}/sections" class="badge badge-primary">View</a>
                    <a onclick="openUpdateCourseModal(`{{$course->course_id}}`, `{{$course->course_name}}`)" class="badge badge-info">Edit</a>
                    <a onclick="openDeleteCourseModal({{$course->course_id}})" class="badge badge-danger">Delete</a>
                  </td>
                </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
         </div>
         </div>
         <!-- /.row -->
       </div>
       <!-- /.container-fluid -->
     </div>
   <!-- /.content -->

@include('admin.lesson_editor_modal')

@endsection

@section('js')
    <script type="text/javascript">
      const openAddCourseModal = () => {
        $('#modal-add-course').modal('show')
      }

      $('#form-add-course').on('submit', () => {
        $.ajax({
          url : $(this).attr('action'),
          data : $(this).serialize(),
          method: $(this).attr('method'),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          contentType: false,
          processData: false,
          beforeSend : () => {
            $('#modal-add-course').modal('hide');
            Swal.showLoading()
          },
          success : () => {
            msg('success', 'Course has been added!')
            window.location = '/admin/courses'
          },
          error: (error) => {
          msg('error', 'Failed to add the course!')
            console.log(error)
          }
        })
      })

      const openUpdateCourseModal = (id, name) => {
        $('#modal-update-course').modal('show')
        $('#course_id').val(id)
        $('#course_name').val(name)
      }

      $('#form-update-course').on('submit', () => {
        $.ajax({
          url : $(this).attr('action'),
          data : $(this).serialize(),
          method : $(this).attr('method'),
          contentType: false,
          processData: false,
          beforeSend : () => {
            $('#modal-update-course').modal('hide');
            Swal.showLoading()
          },
          success : () => {
            msg('success', 'Course has been updated!')
            window.location = '/admin/courses'
          },
          error: (error) => {
            msg('error', 'Failed to update the course!')
            console.log(error)
          }
        });
      });

      const openDeleteCourseModal = (id) => {
        course_id = id
        Swal.fire({
            title: 'Delete this course?',
            text: "Course will be removed!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Remove!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
              url:'/admin/courses/delete/' + course_id,
              type: 'GET',
              success: function() {
                  Swal.fire({
                        title: 'Deleted!',
                        text: 'Course has been removed!',
                        icon: 'success',
                      }).then(function() {
                    location.reload();
                  });
                },
                error: function() {
                  Swal.fire({
                        title: 'Failed!',
                        text: 'Failed to remove the course!',
                        icon: 'danger',
                      }).then(function() {
                    location.reload();
                  });
                }
              })
            }
          })
      }
    </script>
@endsection

