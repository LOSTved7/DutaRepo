@extends('layouts.header')

@section('title')
Dashboard
@endsection

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f4f6f9;
      padding: 30px;
    }

   .header {
      background: linear-gradient(135deg, #f9fafc, #e6ecf3);
      padding: 25px 35px;
      border-radius: 20px;
      margin-bottom: 30px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: all 0.3s ease-in-out;
    }

    .header h2 {
      font-size: 2rem;
      font-weight: 600;
      color: #2c3e50;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }

    .header p {
      font-size: 1.1rem;
      color: #4a4a4a;
      font-weight: 500;
      margin: 0;
    }


    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }

    .card {
        background: linear-gradient(145deg, #fefefe, #e7eaf0);
        border-radius: 16px;
        padding: 25px 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      }
      .card i {
        font-size: 2.5rem;
        color: #3E8E7E;
      }
      .card h3 {
        margin-top: 15px;
        font-size: 1.2rem;
        color: #333;
      }



    h2 {
      margin-top: 40px;
      margin-bottom: 20px;
    }

  .timeline {
    position: relative;
    margin: 20px 0;
    padding-left: 30px;
  }

  .timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #0a2e5c;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 30px;
    padding-left: 20px;
  }

  .timeline-item::before {
    content: '';
    position: absolute;
    left: -3px;
    top: 5px;
    width: 12px;
    height: 12px;
    background: #FFD700;
    border-radius: 50%;
    border: 2px solid #0a2e5c;
  }

  .timeline-time {
    font-weight: bold;
    color: #0a2e5c;
    font-size: 16px;
  }

  .timeline-content {
    color: #333;
    margin-top: 5px;
    background: #f4f6f9;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }


  .no-class-card {
  background: linear-gradient(135deg, #f7f9fc, #e4ebf5);
  border-left: 5px solid #4a90e2;
  padding: 30px 20px;
  margin: 30px auto;
  border-radius: 12px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  text-align: center;

  /* updated size */
  width: 80%;
  max-width: 800px;

  animation: fadeInCard 0.6s ease-in-out both;
  transition: transform 0.3s ease;
}

.no-class-card:hover {
  transform: scale(1.02);
}

.no-class-card h3 {
  color: #2c3e50;
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 10px;
}

.no-class-card p {
  font-size: 15px;
  color: #555;
  margin-top: 0;
}

.no-class-icon {
  font-size: 40px;
  margin-bottom: 12px;
  color: #4a90e2;
}

@keyframes fadeInCard {
  0% {
    opacity: 0;
    transform: translateY(15px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
  </style>
  @endsection

@section('content')
<div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            </div>
            <!--end breadcrumb-->

            <div class="card" style="margin-top: -70px;">
                <div class="header">
                  <h2 style="margin-top:-20px"><b>{{$user_profile_data->name}}</b></h2>
                  <p style="font-size:17px"><strong>Course : {{!empty($course_mast[$user_profile_data->course_id])?$course_mast[$user_profile_data->course_id]:'-'}} | Designation: Student</strong><br>
                    <strong>College Roll No. - {{!empty($user_profile_data->roll_no)?$user_profile_data->roll_no:'N/A'}} | Examination Roll No. - {{!empty($user_profile_data->examination_roll_no)?$user_profile_data->examination_roll_no:'N/A'}} | Enrollment No. - {{!empty($user_profile_data->enrolment_no)?$user_profile_data->enrolment_no:'N/A'}}</strong></p>
                </div>

                <div class="card-container">
                  <div class="card" style="background: linear-gradient(145deg, #0a2e5c, #163b6c);color: #ffffff;">
                    <i class="fas fa-calendar-alt fa-2x" style="color: #FFD700;"></i>
                    <h3 style="color: #ffffff">{{count($today_lecture_detail)}} Classes Today</h3>
                  </div>
                  <div class="card" style="background: linear-gradient(145deg, #0a2e5c, #163b6c);color: #ffffff;">
                    <i class="fas fa-user-check fa-2x" style="color: #FFD700;"></i>
                    <h3 style="color: #ffffff">Overall Attendance : {{$overall_percentage}}%</h3>
                  </div>
                  <div class="card" style="background: linear-gradient(145deg, #0a2e5c, #163b6c);color: #ffffff;">
                    <i class="fas fa-book fa-2x" style="color: #FFD700;"></i>
                    <h3 style="color: #ffffff">{{$pending_assignment_count}} Assignment Pending</h3>
                  </div>
                  <div class="card" style="background: linear-gradient(145deg, #0a2e5c, #163b6c);color: #ffffff;">
                    <i class="fas fa-umbrella-beach fa-2x" style="color: #FFD700;"></i>
                    <h3 style="color: #ffffff">{{$fac_on_leave}} Faculty On Leave Today</h3>
                  </div>
                </div>
                <hr style="solid #2e3337;opacity:1">

                <h2>Today's Timetable</h2>

                @if(count ($today_lecture_detail) == 0)
                   <div class="no-class-card">
                      <div class="no-class-icon">📚</div>
                      <h3>No Classes Today 😊</h3>
                    </div>
                @else
                  <div class="timeline">
                    @foreach($today_lecture_detail as $key => $value)
                      <div class="timeline-item">
                        <div class="timeline-time">{{ date('g:i A', strtotime($value->timing)) }}</div>
                        <div class="timeline-content" style="font-size:17px">
                          {{ $subject_mast[$value->subject_id] ?? '-' }}<br>
                          Room - {{ $room_mast[$value->room_id] ?? '-' }}
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif

                <hr style="solid #2e3337;opacity:1">


                  <h2 style="">Subject-wise Attendance Summary</h2>
                  @if(count($subject_percent_arr) > 0)
                  <div style="max-width: 600px; margin: 0 auto; ">
                  <canvas id="attendancePieChart" width="500" height="500"></canvas>
                </div>
                @else
                <div class="no-class-card">
                      <div class="no-class-icon">📚</div>
                      <h3>No Data Found 😊</h3>
                    </div>
                @endif


              </div>
            </div>
          </div>
  @endsection
  @section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const pieLabels = {!! json_encode(array_keys($subject_percent_arr)) !!};
  const pieData = {!! json_encode(array_values($subject_percent_arr)) !!};

  // Generate unique random colors for each subject
  const pieColors = pieLabels.map(() => {
    const randomColor = '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0');
    return randomColor;
  });

  const ctx = document.getElementById('attendancePieChart').getContext('2d');

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: pieLabels,
      datasets: [{
        label: 'Subject Attendance %',
        data: pieData,
        backgroundColor: pieColors,
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return context.label + ': ' + context.parsed + '%';
            }
          }
        }
      }
    }
  });
</script>


@endsection


