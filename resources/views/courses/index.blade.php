<x-app-layout>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>

    <!-- ===== Header ===== -->
    <div class="bg-white pt-12 pb-10 border-b border-gray-100">
        <div class="text-center mb-10">
            <h1 class="text-5xl font-extrabold tracking-tight">
                <span class="text-[#3d4f8f]">Courses</span>
                <span class="text-[#ff8c61]"> List</span>
            </h1>
        </div>
    </div>

    <!-- ===== Courses Cards ===== -->
    <div class="bg-[#f8f9fa] py-16">
        <div class="max-w-[1400px] mx-auto px-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            @forelse($courses as $course)
                <div class="bg-[#004d8c] rounded-[2.5rem] flex flex-col shadow-lg overflow-hidden">

                    <!-- Image -->
                    <div class="h-48 flex items-center justify-center p-10">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}"
                                 alt="{{ $course->title }}"
                                 class="max-h-full max-w-full object-contain">
                        @else
                            <div class="text-white text-6xl font-black italic opacity-20">
                                LOGO
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-t-[3.5rem] p-8 flex flex-col flex-grow shadow-[0_-15px_30px_rgba(0,0,0,0.08)] -mt-2">

                        <div class="text-center mb-6 flex-grow">
                            <h3 class="text-2xl font-bold mb-3 text-[#1a1a1a]">
                                {{ $course->title }}
                            </h3>

                            <p class="text-[11px] text-gray-400 font-semibold leading-relaxed px-2 uppercase">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <p class="mt-2 text-xs text-gray-500 font-semibold">
                                Teacher: {{ $course->teacher->name }}
                            </p>
                        </div>

                        <!-- Buttons -->
                        <div class="space-y-4">

                            <!-- Enroll = Register -->
                            <form method="POST"
                                  action="{{ route('student.courses.register', $course->id) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-center
                                           bg-white border border-[#ff8c61]
                                           text-[#ff8c61] py-3 rounded-full
                                           text-[11px] font-extrabold uppercase
                                           hover:bg-[#ff8c61] hover:text-white transition">
                                    Enroll Now
                                </button>
                            </form>

                            <button
                                class="w-full bg-[#ff8c61] text-white py-3.5 rounded-full
                                       text-[11px] font-extrabold uppercase shadow-lg
                                       shadow-[#ff8c61]/30 hover:bg-[#e67e56] transition">
                                Download Curriculum
                            </button>

                        </div>

                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-gray-400">
                    No courses available.
                </div>
            @endforelse

        </div>
    </div>


    <style>
  /* SweetAlert2 - Site Style */
  .site-swal-popup{
    border-radius: 18px !important;
    padding: 22px 22px 18px !important;
    background: #ffffff !important;
    box-shadow: 0 18px 45px rgba(61,79,143,.18) !important;
    border: 1px solid rgba(61,79,143,.10) !important;
  }

  .site-swal-title{
    color: #3d4f8f !important;
    font-weight: 800 !important;
    letter-spacing: .2px !important;
    font-size: 26px !important;
    margin-top: 6px !important;
  }

  .site-swal-text{
    color: #64748b !important;
    font-size: 15px !important;
    line-height: 1.6 !important;
    margin-top: 6px !important;
  }

  /* Icon look (no harsh borders) */
  .site-swal-icon{
    border-color: rgba(255,140,97,.25) !important;
  }

  /* Buttons */
  .site-swal-confirm{
    border-radius: 14px !important;
    padding: 12px 18px !important;
    background: linear-gradient(135deg, #ff8c61, #ffa07a) !important;
    color: #fff !important;
    font-weight: 700 !important;
    box-shadow: 0 10px 22px rgba(255,140,97,.25) !important;
  }
  .site-swal-confirm:hover{
    transform: translateY(-1px);
    box-shadow: 0 14px 28px rgba(255,140,97,.30) !important;
  }
  .site-swal-confirm:focus{
    box-shadow: 0 0 0 4px rgba(255,140,97,.25) !important;
  }

  /* Optional: container blur feel */
  .site-swal-backdrop{
    background: rgba(15,23,42,.35) !important;
    backdrop-filter: blur(6px);
  }
</style>

    <!-- ===== SweetAlert ===== -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
  Swal.fire({
    icon: 'success',
    title: 'Request Sent Successfully',
    text: @json(session('success')),
    confirmButtonText: 'Okay',
    buttonsStyling: false,
    customClass: {
      popup: 'site-swal-popup',
      title: 'site-swal-title',
      htmlContainer: 'site-swal-text',
      confirmButton: 'site-swal-confirm',
      icon: 'site-swal-icon',
      container: 'site-swal-backdrop'
    },
    showClass: { popup: 'animate__animated animate__fadeInUp animate__faster' },
    hideClass: { popup: 'animate__animated animate__fadeOutDown animate__faster' }
  });
</script>
    @endif

</x-app-layout>