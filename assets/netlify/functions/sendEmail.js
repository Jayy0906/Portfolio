
const nodemailer = require('nodemailer');

exports.handler = async (event, context) => {
  const { name, email, message } = JSON.parse(event.body);

  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      user: "patljoy8@gmail.com", // Replace with your email
      pass: "btae nulb iaun pbgc", // Replace with your email password or app password
    },
  });

  const mailOptionsToAgency = {
    from: email,
    to: 'patljoy8@gmail.com',
    subject: `Contact Form Submission from ${name}`,
    text: `Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`,
  };

  const mailOptionsToUser = {
    from: 'patljoy8@gmail.com',
    to: email,
    subject: `Welcome to MetaArt '${name}'`,
    text: `Dear ${name},\n\nThank you for reaching out to us. We have received your message and will get back to you as soon as possible.\n\nYour message:\n${message}\n\nBest regards,\nMetaArt Team`,
  };

  try {
    await transporter.sendMail(mailOptionsToAgency);
    await transporter.sendMail(mailOptionsToUser);
    return {
      statusCode: 200,
      body: 'Email sent successfully!',
    };
  } catch (error) {
    return {
      statusCode: 500,
      body: `Error sending email: ${error.message}`,
    };
  }
};
