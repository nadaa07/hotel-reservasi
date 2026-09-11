document.addEventListener('DOMContentLoaded', function () {

    const formReservasi =
        document.querySelector('form');

    if (!formReservasi) {
        return;
    }

    formReservasi.addEventListener(
        'submit',
        function (e) {

            const checkin =
                document.getElementById('tgl_checkin');

            const checkout =
                document.getElementById('tgl_checkout');

            if (
                !checkin ||
                !checkout
            ) {
                return;
            }

            if (
                checkin.value === '' ||
                checkout.value === ''
            ) {

                alert(
                    'Tanggal check in dan check out wajib diisi.'
                );

                e.preventDefault();
                return;
            }

            const tanggalCheckin =
                new Date(checkin.value);

            const tanggalCheckout =
                new Date(checkout.value);

            if (
                tanggalCheckout <= tanggalCheckin
            ) {

                alert(
                    'Tanggal check out harus setelah tanggal check in.'
                );

                e.preventDefault();
                return;
            }

            const hariIni = new Date();

            hariIni.setHours(
                0,
                0,
                0,
                0
            );

            if (
                tanggalCheckin < hariIni
            ) {

                alert(
                    'Tanggal check in tidak boleh sebelum hari ini.'
                );

                e.preventDefault();
                return;
            }

        }
    );

});