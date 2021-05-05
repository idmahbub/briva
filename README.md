# Unofficial Briva
## _BRIVA API For Laravel_

Package ini dapat mempermudah Anda menggunakan layanan virtual account BRI (BRIVA).

## Feature
- [BrivaCreate] - digunakan untuk membuat virtual account BRI baru.
- [BrivaRead] - digunakan untuk mendapatkan informasi virtual account yang telah dibuat.
- [BrivaReadStatus] - Semua akun BRIVA memiliki statusBayar atau status pembayaran. Fungsi ini digunakan untuk mendapatkan status pembayaran dari akun BRIVA yang ada.
- [BrivaUpdateStatus] - digunakan untuk mengelola status pembayaran dari akun BRIVA yang ada
- [BrivaUpdate] - digunakan untuk memperbarui detail akun BRIVA yang ada.
- [BrivaDelete] - digunakan untuk menghapus akun BRIVA yang ada
- [BrivaGetReport] - digunakan untuk mendapatkan riwayat transaksi semua akun BRIVA yang terdaftar pada nomor BRIVA Anda.
- [BrivaGetReportTime] - digunakan untuk mendapatkan riwayat transaksi akun BRIVA yang teregistrasi berdasarkan waktu pada nomor BRIVA Anda

## Installation

Install the package with composer

```sh
composer require aditnanda/unofficialbriva
```

Add this code at .env file for configuration

```sh
BRIVA_CONSUMER_KEY="xxxxxxxxxxxxxxxxx"
BRIVA_CONSUMER_SECRET="xxxxxxxxxxxx"
BRIVA_NO="xxxxx"
BRIVA_INSTITUTION_CODE="xxxxxx"
BRIVA_PRODUCTION=false / true
```

## Penggunaan

**inisialisasi awal**
```sh
$briva = new Briva();
```
**BrivaCreate**
```sh
$array = [
    'custCode' => '16416516456',
    'nama' => 'Aditya Nanda',
    'ammount' => '10000',
    'keterangan' => 'Test',
    'expiredDate' => '2017-09-10 09:57:26'
];
$result = $briva->BrivaCreate($array);
```

**BrivaRead**
```sh
$array = [
    'custCode' => '16416516456'
];
$result = $briva->BrivaRead($array);
```
**BrivaReadStatus**
```sh
$array = [
    'custCode' => '16416516456'
];
$result = $briva->BrivaReadStatus($array);
```

**BrivaUpdateStatus**
```sh
$array = [
    'custCode' => '16416516456',
    'statusBayar' => 'N'
];
// status bayar N = false, Y = true
$result = $briva->BrivaUpdateStatus($array);
```

**BrivaUpdate**
```sh
$array = [
    'custCode' => '16416516456',
    'nama' => 'Aditya Nanda',
    'ammount' => '10000',
    'keterangan' => 'Test',
    'expiredDate' => '2017-09-10 09:57:26'
];
$result = $briva->BrivaUpdate($array);
```

**BrivaDelete**
```sh
$array = [
    'custCode' => '16416516456'
];
$result = $briva->BrivaDelete($array);
```

**BrivaGetReport**
```sh
$array = [
    'start_date' => '20200101',
    'end_date' => '20200101',
];
$result = $briva->BrivaGetReport($array);
```

**BrivaGetReportTime**
```sh
$array = [
    'start_date' => '2020-01-01',
    'end_date' => '2020-01-01',
    'start_time' => '10:00',
    'end_time' => '19:00',
];
$result = $briva->BrivaGetReportTime($array);
```

## License

MIT

Visit [BRIVA API](https://developers.bri.co.id/docs/briva)

[Fork from](https://github.com/aditnanda/unofficialbriva)