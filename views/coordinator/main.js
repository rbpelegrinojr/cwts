const { app, BrowserWindow, ipcMain } = require('electron');
const path = require('path');
const { execFile } = require('child_process');

function createWindow() {
  const win = new BrowserWindow({
    width: 600,
    height: 400,
    webPreferences: {
      preload: path.join(__dirname, 'preload.js'),
      nodeIntegration: true,
      contextIsolation: false
    }
  });

  win.loadFile('index.html');
}

// When HTML sends "open-register-app", run your EXE
ipcMain.on('open-register-app', (event) => {
  const exePath = 'C:\\Users\\Adhara_Reign\\Documents\\PythonProjects\\FingerPrint\\dist\\Register.exe';

  execFile(exePath, (error) => {
    if (error) {
      console.error('Failed to open app:', error);
      event.reply('app-status', 'Failed to open Register.exe.');
    } else {
      event.reply('app-status', 'Register.exe opened successfully!');
    }
  });
});

app.whenReady().then(() => {
  createWindow();

  app.on('activate', function () {
    if (BrowserWindow.getAllWindows().length === 0) createWindow();
  });
});

app.on('window-all-closed', function () {
  if (process.platform !== 'darwin') app.quit();
});
