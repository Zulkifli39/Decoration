<?php
session_start();
require('../includes/config.php'); 
require('../Admin/fpdf/fpdf.php'); // Pastikan path ini sesuai dengan folder Anda

// Ambil bulan dari parameter GET
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

// Query data berdasarkan bulan
$query = "SELECT * FROM pemesanan WHERE MONTH(tanggal_acara) = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $bulan);
$stmt->execute();
$result = $stmt->get_result();

// Inisialisasi FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, "Laporan Pemesanan Bulan $bulan", 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(40, 10, 'Nama', 1);
$pdf->Cell(30, 10, 'Telepon', 1);
$pdf->Cell(50, 10, 'Alamat', 1);
$pdf->Cell(25, 10, 'Tanggal', 1);
$pdf->Cell(30, 10, 'Status', 1);
$pdf->Ln();

// Data tabel
$pdf->SetFont('Arial', '', 10);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $row['id'], 1);
    $pdf->Cell(40, 10, $row['nama'], 1);
    $pdf->Cell(30, 10, $row['telepon'], 1);
    $pdf->Cell(50, 10, $row['alamat'], 1);
    $pdf->Cell(25, 10, $row['tanggal_acara'], 1);
    $pdf->Cell(30, 10, $row['status'], 1);
    $pdf->Ln();
}

// Output PDF
$pdf->Output('D', "Laporan_Pemesanan_Bulan_$bulan.pdf");
exit;
?>
