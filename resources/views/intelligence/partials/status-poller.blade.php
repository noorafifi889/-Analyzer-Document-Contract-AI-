@if ($document && !in_array($document->status, ['done', 'failed']))
    <script>
        (function() {
            const statusUrl = "{{ route('documents.status', $document->id) }}";
            const progressBarFill = document.getElementById('progressBarFill');
            const progressPercentText = document.getElementById('progressPercentText');

            const pollInterval = setInterval(async () => {
                try {
                    const res = await fetch(statusUrl, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const data = await res.json();

                    // تحديث شريط التقدم مباشرة بدون Refresh
                    if (progressBarFill) {
                        progressBarFill.style.width = data.progress + '%';
                    }
                    if (progressPercentText) {
                        progressPercentText.textContent = data.progress + '%';
                    }

                    // لما يخلص التحليل أو يفشل، حوّله تلقائياً
                    if (data.status === 'done' || data.status === 'failed') {
                        clearInterval(pollInterval);
                        window.location.reload();
                    }
                } catch (e) {
                    console.error('Status polling error:', e);
                }
            }, 3000); 
        })();
    </script>
@endif