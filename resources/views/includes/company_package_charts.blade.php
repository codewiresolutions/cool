<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        const company = {
            availed_cvs_quota: {{ Auth::guard('company')->user()->company->availed_cvs_quota ?? 0 }},
            cvs_quota: {{ Auth::guard('company')->user()->company->cvs_quota ?? 0 }},
            availed_download_resume_quota: {{ Auth::guard('company')->user()->company->availed_download_resume_quota ?? 0 }},
            download_resume_quota: {{ Auth::guard('company')->user()->company->download_resume_quota ?? 0 }},
            availed_jobs_quota: {{ Auth::guard('company')->user()->company->availed_jobs_quota ?? 0 }},
            jobs_quota: {{ Auth::guard('company')->user()->company->jobs_quota ?? 0 }},
            availed_users_quota: {{ Auth::guard('company')->user()->company->availed_users_quota ?? 0 }},
            users_quota: {{ Auth::guard('company')->user()->company->users_quota ?? 0 }}
        };

        drawQuotaChart('Viewed CVs', company.availed_cvs_quota, company.cvs_quota, 'donutchartCvs');
        drawQuotaChart('Available Downloads', company.availed_download_resume_quota, company.download_resume_quota, 'donutchartDownloads');
        drawQuotaChart('Job Quota', company.availed_jobs_quota, company.jobs_quota, 'donutchartJobs');
        drawQuotaChart('Company Users Quota', company.availed_users_quota, company.users_quota, 'donutchartUsers');
    }


    function drawQuotaChart(title, utilized, total, elementId) {
        const remaining = total - utilized;

        if (utilized === 0 && remaining === 0) {
            document.getElementById(elementId).innerHTML = '<p class="text-muted">No data available</p>';
            return;
        }

        const data = google.visualization.arrayToDataTable([
            ['Quota', 'Count'],
            ['Utilized', utilized],
            ['Remaining', remaining]
        ]);

        const options = {
            title: title,
            pieHole: 0.4,
            slices: {
                0: {color: '#007bff'},
                1: {color: '#cce5ff'}
            },
        };

        const chart = new google.visualization.PieChart(document.getElementById(elementId));
        chart.draw(data, options);
    }
</script>