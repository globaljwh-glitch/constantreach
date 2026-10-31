<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Advanced Contact Form</title>
  <style>
    :root {
      --primary: #4f46e5;
      --primary-hover: #4338ca;
      --background: #f1f5f9;
      --card-bg: #ffffff;
      --text: #0f172a;
      --text-muted: #64748b;
      --border: #cbd5e1;
      --focus-ring: rgba(79, 70, 229, 0.15);
      --gradient: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
      --error: #ef4444;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
      background-color: var(--background);
      color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 40px 20px;
    }

    .form-wrapper {
      background: var(--card-bg);
      border-radius: 24px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      width: 100%;
      max-width: 1100px;
      overflow: hidden;
      display: grid;
      grid-template-columns: 1fr;
    }

    @media (min-width: 992px) {
      .form-wrapper {
        grid-template-columns: 340px 1fr;
      }
    }

    .info-panel {
      background: var(--gradient);
      color: white;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
    }

    .info-panel::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=600&q=80') center/cover;
      opacity: 0.12;
      mix-blend-mode: overlay;
    }

    .info-content {
      position: relative;
      z-index: 1;
    }

    .info-content h2 {
      font-size: 26px;
      font-weight: 700;
      margin-bottom: 12px;
      letter-spacing: -0.5px;
    }

    .info-content p {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.85);
      line-height: 1.6;
    }

    .contact-details {
      margin-top: 40px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .detail-item {
      display: flex;
      align-items: center;
      gap: 14px;
      font-size: 14px;
    }

    .detail-item .icon-box {
      background: rgba(255, 255, 255, 0.15);
      width: 38px;
      height: 38px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .detail-item svg {
      width: 18px;
      height: 18px;
      fill: currentColor;
    }

    .form-panel {
      padding: 40px;
    }

    .section-title {
      grid-column: span 2;
      font-size: 16px;
      font-weight: 700;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 10px;
      margin-bottom: 5px;
      border-bottom: 1px solid var(--border);
      padding-bottom: 6px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
      margin-bottom: 28px;
    }

    @media (min-width: 650px) {
      .form-grid {
        grid-template-columns: repeat(2, 1fr);
      }
      .full-width {
        grid-column: span 2;
      }
      .three-column-row {
        grid-column: span 2;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
      }
      .address-city-row {
        grid-column: span 2;
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
      }
    }

    .form-group {
      position: relative;
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrapper svg {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      width: 18px;
      height: 18px;
      fill: var(--text-muted);
      pointer-events: none;
      transition: fill 0.2s;
    }

    .form-input {
      width: 100%;
      padding: 14px 14px 14px 46px;
      border: 1px solid var(--border);
      border-radius: 12px;
      background: #f8fafc;
      font-size: 15px;
      color: var(--text);
      outline: none;
      transition: all 0.2s ease;
    }

    select.form-input {
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 16px center;
      background-size: 16px;
      padding-right: 40px;
    }

    .form-input:focus {
      border-color: var(--primary);
      background: #ffffff;
      box-shadow: 0 0 0 4px var(--focus-ring);
    }

    .form-input:focus + svg {
      fill: var(--primary);
    }

    .form-input.is-invalid {
      border-color: var(--error);
      background: #fff5f5;
    }

    .error-feedback {
      color: var(--error);
      font-size: 12px;
      margin-top: 4px;
      font-weight: 500;
    }

    .form-group label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 6px;
      color: var(--text-muted);
    }

    .captcha-container {
      display: flex;
      align-items: center;
      gap: 15px;
      background: #f8fafc;
      padding: 10px 16px;
      border-radius: 12px;
      border: 1px solid var(--border);
      margin-bottom: 10px;
    }

    .captcha-img {
      background: #e2e8f0;
      padding: 8px 16px;
      font-weight: 700;
      font-size: 18px;
      letter-spacing: 4px;
      font-style: italic;
      color: var(--primary);
      border-radius: 8px;
      user-select: none;
    }

    .submit-btn {
      width: 100%;
      padding: 15px;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      transition: background-color 0.2s, transform 0.1s;
    }

    .submit-btn:hover {
      background-color: var(--primary-hover);
    }

    .submit-btn:active {
      transform: scale(0.99);
    }

    .alert-success {
      background-color: #d1fae5;
      color: #065f46;
      padding: 16px;
      border-radius: 12px;
      margin-bottom: 20px;
      font-size: 14px;
      font-weight: 600;
    }
    .submit-btn svg {
    width: 16px;
    height: 16px;
    fill: currentColor;
}
  </style>
</head>
<body>

  <div class="form-wrapper">
    <div class="info-panel">
      <div class="info-content">
        <h2>Let's talk business</h2>
        <p>Fill out the form and our growth team will connect with you within 24 hours.</p>
        
        <div class="contact-details">
          <div class="detail-item">
            <div class="icon-box">
              <svg viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383z"/></svg>
            </div>
            <span>noreply@constantemails.com</span>
          </div>
          <div class="detail-item">
            <div class="icon-box">
              <svg viewBox="0 0 16 16"><path d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/></svg>
            </div>
            <span>+1 (555) 019-2834</span>
          </div>
          <div class="detail-item">
            <div class="icon-box">
              <svg viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>
            </div>
            <span>New Jercy, NJ</span>
          </div>
        </div>
      </div>
    </div>

    <div class="form-panel">
      @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
      @endif

      <!-- <form action="{{ route('contact.submit') }}" method="POST"> -->
        <form id="contactForm">
        @csrf

        <div class="form-grid">
          <div class="section-title">Contact Info</div>

          <div class="form-group">
            <label for="first_name">First Name</label>
            <div class="input-wrapper">
              <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="form-input @error('first_name') is-invalid @enderror" >
              <svg viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
            </div>
            @error('first_name') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="last_name">Last Name</label>
            <div class="input-wrapper">
              <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-input @error('last_name') is-invalid @enderror" >
              <svg viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
            </div>
            @error('last_name') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-wrapper">
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input @error('email') is-invalid @enderror" >
              <svg viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383z"/></svg>
            </div>
            @error('email') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="phone">Phone Number</label>
            <div class="input-wrapper">
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="form-input @error('phone') is-invalid @enderror" required>
              <svg viewBox="0 0 16 16"><path d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/></svg>
            </div>
            @error('phone') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="section-title">Address Details</div>

          <!-- Address and City in One Row -->
          <div class="address-city-row">
            <div class="form-group">
              <label for="address">Street Address</label>
              <div class="input-wrapper">
                <input type="text" id="address" name="address" value="{{ old('address') }}" class="form-input @error('address') is-invalid @enderror" required>
                <svg viewBox="0 0 16 16"><path d="M8 0.5a5.5 5.5 0 0 0-5.5 5.5c0 4.25 5.5 9.5 5.5 9.5s5.5-5.25 5.5-9.5a5.5 5.5 0 0 0-5.5-5.5zM8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
              </div>
              @error('address') <div class="error-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label for="city">City</label>
              <div class="input-wrapper">
                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-input @error('city') is-invalid @enderror" required>
                <svg viewBox="0 0 16 16"><path d="M14.708 11.108a1 1 0 0 0-.708-.292H2a1 1 0 0 0-.708.292A1 1 0 0 0 1 11.816V14a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.184a1 1 0 0 0-.292-.708M2 1v10h12V1zM0 11.5a.5.5 0 0 1 .5-.5h15a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5H1.5A1.5 1.5 0 0 1 0 14.5z"/></svg>
              </div>
              @error('city') <div class="error-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <!-- State, Zip, Country Row -->
          <div class="three-column-row">
            <div class="form-group">
              <label for="state">State</label>
              <input type="text" id="state" name="state" value="{{ old('state') }}" class="form-input @error('state') is-invalid @enderror" style="padding-left: 16px;" required>
              @error('state') <div class="error-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label for="zip">Zip / Postal</label>
              <input type="text" id="zip" name="zip" value="{{ old('zip') }}" class="form-input @error('zip') is-invalid @enderror" style="padding-left: 16px;" required>
              @error('zip') <div class="error-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
              <label for="country">Country</label>
              <input type="text" id="country" name="country" value="{{ old('country') }}" class="form-input @error('country') is-invalid @enderror" style="padding-left: 16px;" required>
              @error('country') <div class="error-feedback">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="section-title">Inquiry Specs</div>

          <div class="form-group">
            <label for="products_interested">What products are you interested in?</label>
            <div class="input-wrapper">
              <input type="text" id="products_interested" name="products_interested" value="{{ old('products_interested') }}" class="form-input @error('products_interested') is-invalid @enderror" required>
              <svg viewBox="0 0 16 16"><path d="M2.5 8a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zM2 5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H4z"/></svg>
            </div>
            @error('products_interested') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group">
            <label for="application">Application and Use of Product</label>
            <div class="input-wrapper">
              <select name="application" id="application" class="form-input @error('application') is-invalid @enderror" required>
                <option value="">--Select Application--</option>
                <option value="Personal Care / Cosmetic" {{ old('application') == 'Personal Care / Cosmetic' ? 'selected' : '' }}>Personal Care / Cosmetic</option>
                <option value="Food and Beverage" {{ old('application') == 'Food and Beverage' ? 'selected' : '' }}>Food and Beverage</option>
                <option value="Pharmaceutical" {{ old('application') == 'Pharmaceutical' ? 'selected' : '' }}>Pharmaceutical</option>
                <option value="Flavor and Fragrance" {{ old('application') == 'Flavor and Fragrance' ? 'selected' : '' }}>Flavor and Fragrance</option>
                <option value="Animal Health &amp; Nutrition" {{ old('application') == 'Animal Health &amp; Nutrition' ? 'selected' : '' }}>Animal Health &amp; Nutrition</option>
                <option value="Sport Nutrition" {{ old('application') == 'Sport Nutrition' ? 'selected' : '' }}>Sport Nutrition</option>
                <option value="Industrial" {{ old('application') == 'Industrial' ? 'selected' : '' }}>Industrial</option>
              </select>
              <svg viewBox="0 0 16 16"><path d="M10.478 1.647a.5.5 0 1 0-.956-.294l-4 13a.5.5 0 0 0 .956.294l4-13zM4.854 4.146a.5.5 0 1 0-.708-.708L1.707 5.854a.5.5 0 0 0 0 .708l2.439 2.439a.5.5 0 1 0 .708-.708L2.773 6l2.081-2.146z"/></svg>
            </div>
            @error('application') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="form-group full-width">
            <label for="final_application">Final Application</label>
            <div class="input-wrapper">
              <input type="text" id="final_application" name="final_application" value="{{ old('final_application') }}" class="form-input @error('final_application') is-invalid @enderror" required>
              <svg viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/></svg>
            </div>
            @error('final_application') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Laravel Math Captcha -->
          <div class="form-group full-width">
            <label for="captcha">Security Check</label>
            <div class="captcha-container">
              <div class="captcha-img">{{ session('captcha_num1', rand(1,9)) }} + {{ session('captcha_num2', rand(1,9)) }} =</div>
              <div class="input-wrapper" style="flex-grow: 1;">
                <input type="text" id="captcha" name="captcha" placeholder="Answer" class="form-input @error('captcha') is-invalid @enderror" style="padding-left: 16px;" required>
              </div>
            </div>
            @error('captcha') <div class="error-feedback">{{ $message }}</div> @enderror
          </div>

        </div>

        <button type="submit" class="submit-btn">
          Submit Details
          <svg viewBox="0 0 16 16"><path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/></svg>
        </button>
      </form>
    </div>
  </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#contactForm').on('submit', function(e) {
    e.preventDefault();

    let form = $(this);
    let submitBtn = form.find('[type="submit"]');

    submitBtn.prop('disabled', true).text('Submitting...');

    $.ajax({
        url: '/contact-enquiry-submit',
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',

        success: function(response) {

            if (response.success) {
                alert(response.message || 'Enquiry submitted successfully!');

                form[0].reset();

                // Refresh your existing session-based CAPTCHA
                location.reload();
            } else {
                alert(response.message || 'Unable to submit enquiry.');
            }
        },

        error: function(xhr, status, error) {

          console.log('HTTP Status:', xhr.status);
          console.log('Response:', xhr.responseText);

          let response = xhr.responseJSON;

          alert(
              response?.message ||
              'Something went wrong. Please try again.'
          );
      },

        complete: function() {
            submitBtn.prop('disabled', false).text('Submit');
        }
    });
});

</script>


</body>
</html>