const { app, BrowserWindow } = require("electron");
const path = require("path");
const { exec } = require("child_process");

function createWindow() {
  // Jalankan server PHP sebelum membuka Electron
  exec("php -S localhost:8000 -t antrian", (error, stdout, stderr) => {
    if (error) {
      console.error(`Error: ${error.message}`);
      return;
    }
    if (stderr) {
      console.error(`Stderr: ${stderr}`);
      return;
    }
    console.log(`PHP Server Running:\n${stdout}`);
  });

  // Buat jendela Electron
  const mainWindow = new BrowserWindow({
    width: 800,
    height: 600,
    webPreferences: {
      nodeIntegration: true,
    },
  });

  // Tunggu beberapa detik agar server PHP siap, lalu buka halaman PHP
  setTimeout(() => {
    mainWindow.loadURL("http://localhost:8000/index.php");
  }, 3000); // Tunggu 3 detik sebelum memuat halaman
}

// Jalankan aplikasi saat Electron siap
app.whenReady().then(() => {
  createWindow();

  app.on("activate", function () {
    if (BrowserWindow.getAllWindows().length === 0) createWindow();
  });
});

// Tutup aplikasi jika semua jendela ditutup (kecuali macOS)
app.on("window-all-closed", function () {
  if (process.platform !== "darwin") app.quit();
});
