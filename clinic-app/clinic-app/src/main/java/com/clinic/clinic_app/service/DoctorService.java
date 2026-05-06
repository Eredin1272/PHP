package com.clinic.clinic_app.service;

import com.clinic.clinic_app.dto.DoctorForm;
import com.clinic.clinic_app.model.Doctor;
import com.clinic.clinic_app.repository.DoctorRepository;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class DoctorService {

    private final DoctorRepository doctorRepository;

    public DoctorService(DoctorRepository doctorRepository) {
        this.doctorRepository = doctorRepository;
    }

    /**
     * Возвращает активных врачей, отсортированных по ФИО.
     *
     * @return список активных врачей
     */
    public List<Doctor> findActive() {
        return doctorRepository.findByActiveTrueOrderByFullNameAsc();
    }

    /**
     * Возвращает всех врачей для управления администратором.
     *
     * @return полный список врачей
     */
    public List<Doctor> findAll() {
        return doctorRepository.findAll();
    }

    /**
     * Находит врача по идентификатору.
     *
     * @param id идентификатор врача
     * @return найденный врач
     * @throws IllegalArgumentException если врач не найден
     */
    public Doctor findById(Long id) {
        return doctorRepository.findById(id)
                .orElseThrow(() -> new IllegalArgumentException("Doctor not found"));
    }

    /**
     * Ищет врачей по ФИО или специализации.
     *
     * @param query текст поиска; пустое значение возвращает активных врачей
     * @return врачи, соответствующие поисковому запросу
     */
    public List<Doctor> search(String query) {
        if (query == null || query.isBlank()) {
            return findActive();
        }
        return doctorRepository.findByFullNameContainingIgnoreCaseOrSpecializationContainingIgnoreCase(query, query);
    }

    /**
     * Создаёт врача из проверенных данных формы.
     *
     * @param form данные формы врача
     * @return сохранённый врач
     */
    public Doctor create(DoctorForm form) {
        return save(new Doctor(), form);
    }

    /**
     * Обновляет существующего врача из проверенных данных формы.
     *
     * @param id идентификатор врача
     * @param form данные формы врача
     * @return обновлённый врач
     */
    public Doctor update(Long id, DoctorForm form) {
        return save(findById(id), form);
    }

    /**
     * Удаляет врача по идентификатору.
     *
     * @param id идентификатор врача
     */
    public void delete(Long id) {
        doctorRepository.deleteById(id);
    }

    /**
     * Преобразует сущность врача в объект формы для редактирования.
     *
     * @param doctor сущность врача
     * @return заполненная форма врача
     */
    public DoctorForm toForm(Doctor doctor) {
        DoctorForm form = new DoctorForm();
        form.setFullName(doctor.getFullName());
        form.setSpecialization(doctor.getSpecialization());
        form.setExperienceYears(doctor.getExperienceYears());
        form.setOffice(doctor.getOffice());
        form.setActive(doctor.getActive());
        return form;
    }

    private Doctor save(Doctor doctor, DoctorForm form) {
        doctor.setFullName(form.getFullName());
        doctor.setSpecialization(form.getSpecialization());
        doctor.setExperienceYears(form.getExperienceYears());
        doctor.setOffice(form.getOffice());
        doctor.setActive(Boolean.TRUE.equals(form.getActive()));
        return doctorRepository.save(doctor);
    }
}
