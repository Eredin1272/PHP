package com.clinic.clinic_app.service;

import com.clinic.clinic_app.dto.AppointmentForm;
import com.clinic.clinic_app.dto.AppointmentSearchForm;
import com.clinic.clinic_app.model.Appointment;
import com.clinic.clinic_app.model.AppointmentStatus;
import com.clinic.clinic_app.repository.AppointmentRepository;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class AppointmentService {

    private final AppointmentRepository appointmentRepository;
    private final DoctorService doctorService;
    private final MedicalServiceService medicalServiceService;

    public AppointmentService(
            AppointmentRepository appointmentRepository,
            DoctorService doctorService,
            MedicalServiceService medicalServiceService) {
        this.appointmentRepository = appointmentRepository;
        this.doctorService = doctorService;
        this.medicalServiceService = medicalServiceService;
    }

    /**
     * Создаёт заявку на приём из проверенных данных формы.
     *
     * @param form проверенные данные заявки
     * @return сохранённая заявка
     */
    public Appointment create(AppointmentForm form) {
        Appointment appointment = new Appointment();
        appointment.setPatientName(form.getPatientName());
        appointment.setPhone(form.getPhone());
        appointment.setEmail(form.getEmail());
        appointment.setDoctor(doctorService.findById(form.getDoctorId()));
        appointment.setMedicalService(medicalServiceService.findById(form.getMedicalServiceId()));
        appointment.setAppointmentTime(form.getAppointmentTime());
        appointment.setComplaint(form.getComplaint());
        appointment.setStatus(AppointmentStatus.NEW);
        return appointmentRepository.save(appointment);
    }

    /**
     * Возвращает все заявки на приём, отсортированные по времени приёма.
     *
     * @return отсортированный список заявок
     */
    public List<Appointment> findAll() {
        return appointmentRepository.findAllByOrderByAppointmentTimeDesc();
    }

    /**
     * Находит заявку по идентификатору.
     *
     * @param id идентификатор заявки
     * @return найденная заявка
     * @throws IllegalArgumentException если заявка не найдена
     */
    public Appointment findById(Long id) {
        return appointmentRepository.findById(id)
                .orElseThrow(() -> new IllegalArgumentException("Appointment not found"));
    }

    /**
     * Ищет заявки по необязательным критериям: ФИО пациента, врач и статус.
     *
     * @param form критерии поиска
     * @return заявки, соответствующие всем указанным критериям
     */
    public List<Appointment> search(AppointmentSearchForm form) {
        String patientName = form.getPatientName() == null ? "" : form.getPatientName().trim().toLowerCase();

        return appointmentRepository.findAllByOrderByAppointmentTimeDesc().stream()
                .filter(appointment -> patientName.isBlank()
                        || appointment.getPatientName().toLowerCase().contains(patientName))
                .filter(appointment -> form.getDoctorId() == null
                        || appointment.getDoctor().getId().equals(form.getDoctorId()))
                .filter(appointment -> form.getStatus() == null
                        || appointment.getStatus() == form.getStatus())
                .toList();
    }

    /**
     * Обновляет статус заявки.
     *
     * @param id идентификатор заявки
     * @param status новое значение статуса
     */
    public void updateStatus(Long id, AppointmentStatus status) {
        Appointment appointment = findById(id);
        appointment.setStatus(status);
        appointmentRepository.save(appointment);
    }

    /**
     * Удаляет заявку по идентификатору.
     *
     * @param id идентификатор заявки
     */
    public void delete(Long id) {
        appointmentRepository.deleteById(id);
    }
}
