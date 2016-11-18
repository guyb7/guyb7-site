#!/usr/bin/env node

'use strict'

const env        = require('node-env-file')
const express    = require('express')
const bodyParser = require('body-parser')
const Mailer     = require('./server/SendMail.js')

env(__dirname + '/config/config.env')
const app = express()

app.use(express.static('static'))

function complete(res, success, error) {
  //TODO handle non ajax
  if (success === true) {
    res.json({success: true})
  } else {
    res.json({success: false, error: error})
  }
}

app.post('/contact', bodyParser.urlencoded({extended: true}), function (req, res) {
  if (!req.body.contact_name || !req.body.contact_email || !req.body.contact_content) {
    complete(res, false, 'error-empty')
  } else if (req.body.contact_content.match(/http/) && !req.body.contact_captcha.match(/(Y7xp33|6Bp9Hz)/i)) {
    complete(res, false, 'error-captcha')
  } else {
    Mailer.send(req.body, function(result) {
      complete(res, result)
    })
  }
})

app.listen(process.env.PORT, function () {
  console.log('Listening on port ' + process.env.PORT)
})
