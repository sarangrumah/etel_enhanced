$(document).ready(function() {
    $("input:file").on('change', async function() {
        const file = this.files[0];
        const allowedMimeType = 'application/pdf';
        const maxFileSize = 5 * 1024 * 1024; // 5MB

        if (!file) {
            return;
        }

        if (file.type !== allowedMimeType) {
            alert('Hanya file dengan format PDF yang diizinkan.');
            $(this).val(''); // Clear the input
            return;
        }

        if (file.size > maxFileSize) {
            alert('Ukuran file tidak boleh melebihi 5MB.');
            $(this).val(''); // Clear the input
            return;
        }

        const reader = new FileReader();
        const promise = new Promise((resolve, reject) => {
            reader.onload = function(e) {
                const content = e.target.result;
                const maliciousPatterns = [
                    /\/JavaScript\b/i,
                    /\/JS\b/i,
                    /\/OpenAction\b/i,
                    /\/AA\b/i,
                    /\/Launch\b/i
                ];

                for (const pattern of maliciousPatterns) {
                    if (pattern.test(content)) {
                        resolve(true); // Malicious pattern found
                        return;
                    }
                }
                resolve(false); // No malicious patterns found
            };
            reader.onerror = function(e) {
                reject(e);
            };
            reader.readAsText(file);
        });

        try {
            const isMalicious = await promise;
            if (isMalicious) {
                alert('File PDF yang Anda unggah terdeteksi mengandung skrip yang tidak diizinkan. Mohon unggah file PDF yang aman.');
                $(this).val(''); // Clear the input
            }
        } catch (error) {
            console.error('Error reading file:', error);
            alert('Terjadi kesalahan saat membaca file.');
            $(this).val(''); // Clear the input
        }
    });
});
