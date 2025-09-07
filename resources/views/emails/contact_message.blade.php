<?php
/** @var \App\Models\ContactMessage $m */

<div style="max-width:500px;margin:auto;border:1px solid #e0e0e0;border-radius:8px;padding:24px;background:#fafafa;font-family:Arial,sans-serif;">
  <h2 style="margin-top:0;color:#2c3e50;">New Contact Message</h2>
  <table style="width:100%;margin-bottom:16px;">
    <tr>
      <td style="font-weight:bold;color:#34495e;">Name:</td>
      <td>{{ $m->name }}</td>
    </tr>
    <tr>
      <td style="font-weight:bold;color:#34495e;">Email:</td>
      <td>{{ $m->email }}</td>
    </tr>
    <tr>
      <td style="font-weight:bold;color:#34495e;">Phone:</td>
      <td>{{ $m->phone ?? '—' }}</td>
    </tr>
    <tr>
      <td style="font-weight:bold;color:#34495e;">Subject:</td>
      <td>{{ $m->subject }}</td>
    </tr>
  </table>
  <div style="margin-bottom:16px;">
    <div style="font-weight:bold;color:#34495e;">Message:</div>
    <div style="white-space:pre-wrap;background:#fff;border-radius:4px;padding:12px;border:1px solid #e0e0e0;">{{ $m->message }}</div>
  </div>
  <hr style="border:none;border-top:1px solid #e0e0e0;">
  <small style="color:#888;">
    Received at {{ $m->created_at->setTimezone('Africa/Lusaka')->format('Y-m-d H:i') }} CAT<br>
    IP: {{ $m->ip }} | UA: {{ $m->ua }}
  </small>
</div>
    white-space:nowrap !important; overflow-wrap:normal !important; word-break:keep-all !important;
  }
</style>                    
                <textarea name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                <div class="invalid-feedback">Please enter your message.</div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                  Send Message
                </button>
                <span>Send Message</span>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>          