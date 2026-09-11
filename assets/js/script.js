document.addEventListener('DOMContentLoaded', function () {

    const checkin = document.getElementById('tgl_checkin');
    const checkout = document.getElementById('tgl_checkout');

    const durasi = document.getElementById('durasi');
    const totalHarga = document.getElementById('total_harga');

    const hargaKamar = document.getElementById('harga_kamar');

    if (
        !checkin ||
        !checkout ||
        !durasi ||
        !totalHarga ||
        !hargaKamar
    ) {
        return;
    }

    function hitungReservasi() {

        const harga = parseInt(hargaKamar.value) || 0;

        const tanggalCheckin = new Date(checkin.value);
        const tanggalCheckout = new Date(checkout.value);

        if (
            checkin.value &&
            checkout.value &&
            tanggalCheckout > tanggalCheckin
        ) {

            const selisihWaktu =
                tanggalCheckout.getTime() -
                tanggalCheckin.getTime();

            const jumlahMalam =
                Math.ceil(
                    selisihWaktu /
                    (1000 * 60 * 60 * 24)
                );

            const total =
                jumlahMalam * harga;

            durasi.innerHTML =
                jumlahMalam + ' Malam';

            totalHarga.innerHTML =
                'Rp ' +
                total.toLocaleString('id-ID');

        } else {

            durasi.innerHTML =
                '0 Malam';

            totalHarga.innerHTML =
                'Rp 0';

        }
    }

    checkin.addEventListener(
        'change',
        hitungReservasi
    );

    checkout.addEventListener(
        'change',
        hitungReservasi
    );

});