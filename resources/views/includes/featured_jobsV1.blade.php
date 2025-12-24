@php use Illuminate\Support\Str; @endphp
<div class="section">
    <div class="container-fluid p-0">
        <div class="row titleTop pl-5 pr-5">
            <h3 class="text-center w-100">Build Your Dream Job</h3>
            <p class="featuredJobsHeading">Featured Jobs</p>
            <p class="featuredJobsdescription">
                A featured job search allows you to influence your user's search results by ranking jobs according to
                promotional value rather than purely by relevance. A featured job search only returns relevant jobs with
                an assigned promotional value.
            </p>
        </div>
        <div class="row">
            <div class="col-lg-2 text-center">
                <div class="feature_jobs_advert">
                    {!! $siteSetting->index_page_below_top_employes_ad !!}
                </div>
            </div>
            <div class="col-lg-9 mt-0 position-relative">
                <ul class="featured-job-list owl-carousel" data-carousel-id="1">
                    @foreach($featuredJobs ?? [] as $featuredJob)
                        @php $company = $featuredJob->getCompany(); @endphp
                        @if($company)
                            <li class="item">
                                <div class="job-card h-100 p-4 rounded">
                                    <div class="d-flex mb-3 align-items-center mb-4">
                                        <div class="company-image  col-lg-3 col-md-3 mr-4 p-0">
                                            <a href="{{ route('job.detail', $featuredJob->slug) }}">
                                                {!! $company->printCompanyImage() !!}
                                            </a>
                                        </div>
                                        <div class="company text-justify">
                                            <a href="{{ route('company.detail', $company->slug) }}"
                                               class="text-dark text-decoration-none company-title">
                                                {{ $company->name }}
                                            </a>
                                            <p class="text-muted">{{ $company->location }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-8 mt-3 mb-4 text-justify">
                                        <h4 class="fw-bold">
                                            <a href="{{ route('job.detail', $featuredJob->slug) }}"
                                               class="text-dark text-decoration-none">
                                                {{ $featuredJob->title }}
                                            </a>
                                        </h4>
                                        <p class="text-muted mb-3">{{ $featuredJob->getJobType('job_type') }}</p>
                                    </div>
                                    
                                    
                                    <div class="company-desc">
                                        <p class="small text-secondary mb-2">
                                            {{ Str::limit(strip_tags($company->description), 400, '...') }}
                                        </p>
                                        
                                        <a href="{{ route('company.detail', $company->slug) }}"
                                           class="small read-more d-inline-block">
                                            Read More
                                        </a>
                                    </div>
                                    <div class="mt-auto d-flex justify-content-end">
                                        <a href="{{ route('job.detail', $featuredJob->slug) }}"
                                           class="btn btn-primary rounded-pill px-4 fw-bold">
                                            Apply Now
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <button class="carousel-prev btn btn-primary position-absolute"
                        style="top:35%; left:10px; transform:translateY(-50%); z-index:10;" data-carousel-id="1">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <button class="carousel-next btn btn-primary position-absolute"
                        style="top:35%; right:10px; transform:translateY(-50%); z-index:10;" data-carousel-id="1">
                    <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
