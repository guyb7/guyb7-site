'use strict'

const nodemailer = require('nodemailer')
const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: process.env.SEND_USER,
    pass: process.env.SEND_PASS
  }
})

module.exports = {
  send(data, cb) {
    const html = `<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width" />
        <title>GuyB7 Contact - Message from ${data.contact_name}</title>
    </head>
    <body>
        <div style="font-weight:bold">Name:</div>
            ${data.contact_name}
        <br><br>
        <div style="font-weight:bold">Email:</div>
            ${data.contact_email}
        <br><br>
        <div style="font-weight:bold">Message:</div>
            ${data.contact_content.replace(/\n/g, '<br>')}
    </body>
</html>`
    const mailOptions = {
      from: '"GuyB7" <' + process.env.SEND_USER + '>',
      to: process.env.SENT_TO,
      subject: 'GuyB7 site - Contact from ' + data.contact_name,
      html: html
    };
    transporter.sendMail(mailOptions, function(error, info){
      cb(error ? false : true)
    })
  }
}
