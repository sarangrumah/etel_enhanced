const fs = require('fs');
const { PDFDocument } = require('pdf-lib');

async function mergePDFs(outputPath, files) {
    const mergedPdf = await PDFDocument.create();

    for (const file of files) {
        const pdfBytes = fs.readFileSync(file);
        const pdf = await PDFDocument.load(pdfBytes);
        const copiedPages = await mergedPdf.copyPages(pdf, pdf.getPageIndices());
        copiedPages.forEach((page) => mergedPdf.addPage(page));
    }

    const mergedPdfFile = await mergedPdf.save();
    fs.writeFileSync(outputPath, mergedPdfFile);
}

const args = process.argv.slice(2);
const outputPath = args[0];
const files = args.slice(1);

mergePDFs(outputPath, files).catch(console.error);
