 <section id="details" class="details">
      <div class="container">

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
           <img src="{{url("bl/assets/img/foto_rektor.png")}}" class="img-fluid" alt="">
          </div>
          <div id="samrek" class="col-md-8 pt-4" data-aos="fade-up">
            <h3>Sambutan Rektor</h3>
            <p class="fst-italic">
              
            </p>
            <ul>
              <li><i class="bi bi-check"> 
               @isset($sambutan[0])
              	{!! $sambutan[0]->isi !!}
               @endisset</i>
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="{{url("bl/assets/img/details-2.png")}}" class="img-fluid" alt="">
          </div>
          <div id="download" class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Download</h3>
            
            @isset($download[0])
			<p class="fst-italic">
              	{!! $download[0]->judul !!} 
            </p>
            {!! $download[0]->isi !!} 
			@endisset
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4" data-aos="fade-right">
            <img src="{{url("bl/assets/img/details-3.png")}}" class="img-fluid" alt="">
          </div>
          <div class="col-md-8 pt-5" data-aos="fade-up">
            <h3>Tata cara pendaftaran</h3>
			 @isset($pendaftaran[0])
            	{!! $pendaftaran[0]->isi !!}
             @endisset
          </div>
        </div>

        <div class="row content">
          <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
            <img src="{{url("bl/assets/img/details-4.png")}}" class="img-fluid" alt="">
          </div>
          <div id="dosen" class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Dosen</h3>
          
          </div>
        </div>
		
		 <div class="row content">
           <div class="col-md-4" data-aos="fade-right">
			  <img src="{{url("bl/assets/img/grafik_dosen.png")}}" class="img-fluid" alt="">
          </div>
          <div id="info" class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
            <h3>Info</h3>
          		 @isset($info[0])
                  {!! $info[0]->isi !!}
                 @endisset
          </div>
        </div>
		
      </div>
    </section><!-- End Details Section -->